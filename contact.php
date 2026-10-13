<?php
/**
 * Tech Force Consulting Engineers — RFQ form handler.
 *
 * Receives the contact form on services.html and emails it to RECIPIENT using
 * PHP mail(), which Hostinger shared/Premium/Business hosting supports.
 *
 * SETUP: create the mailbox below in hPanel → Emails before going live.
 * Hostinger only delivers mail() messages whose From address is a real
 * mailbox on your own domain.
 */

declare(strict_types=1);

// ------------------------------------------------------------------ config
const RECIPIENT    = 'info@techforceconsulting.com';  // where enquiries are delivered
const FROM_ADDRESS = 'info@techforceconsulting.com';  // must be a mailbox on this domain
const SITE_NAME    = 'Tech Force Consulting Engineers';
const RETURN_PAGE  = '/services.html';

const SECTORS  = ['Aerospace', 'Defence', 'Railways', 'Other'];
const SERVICES = [
    'failure-analysis' => 'Material Failure Analysis',
    'welding'          => 'Welding Processes',
    'coining'          => 'Coining & Precision Forming',
    'other'            => 'Multiple / Not sure yet',
];

// ------------------------------------------------------------------ helpers
$wantsJson = strpos($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json') !== false;

function respond(bool $ok, string $message = '', int $code = 200): void
{
    global $wantsJson;
    if ($wantsJson) {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        header('Cache-Control: no-store');
        echo json_encode(['ok' => $ok, 'message' => $message]);
    } else {
        header('Location: ' . RETURN_PAGE . '?status=' . ($ok ? 'sent' : 'error') . '#contact', true, 303);
    }
    exit;
}

/** Trim a single-line field and strip anything that could inject mail headers. */
function line(string $key, int $max): string
{
    $value = trim((string)($_POST[$key] ?? ''));
    $value = preg_replace('/[\r\n\t]+/', ' ', $value) ?? '';
    return mb_substr($value, 0, $max);
}

/** Format "Display Name <email>" safely, encoding non-ASCII names. */
function address(string $name, string $email): string
{
    $name = str_replace(['"', '\\', '<', '>'], '', $name);
    $display = preg_match('/[^\x20-\x7E]/', $name)
        ? mb_encode_mimeheader($name, 'UTF-8')
        : '"' . $name . '"';
    return $display . ' <' . $email . '>';
}

// ------------------------------------------------------------------ guards
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: ' . RETURN_PAGE . '#contact', true, 303);
    exit;
}

// Honeypot: real visitors never see this field. Pretend success so bots move on.
if (trim((string)($_POST['website'] ?? '')) !== '') {
    respond(true);
}

// ------------------------------------------------------------------ validate
$name    = line('name', 100);
$company = line('company', 150);
$email   = line('email', 150);
$phone   = line('phone', 30);
$sector  = line('sector', 20);
$service = line('service', 30);
$message = trim(str_replace("\r\n", "\n", (string)($_POST['message'] ?? '')));
$message = mb_substr($message, 0, 5000);

if ($name === '' || $company === '') {
    respond(false, 'Please enter your name and company.', 422);
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'Please enter a valid email address.', 422);
}
if (!in_array($sector, SECTORS, true)) {
    respond(false, 'Please select an industry sector.', 422);
}
if (!array_key_exists($service, SERVICES)) {
    respond(false, 'Please select the service you need.', 422);
}
if (mb_strlen($message) < 20) {
    respond(false, 'Please add a few more details about your project (at least 20 characters).', 422);
}

// ------------------------------------------------------------------ send
$serviceLabel = SERVICES[$service];
$subject = 'New RFQ: ' . $serviceLabel . ' — ' . $company;

$body = implode("\n", [
    'New enquiry from the website contact form',
    str_repeat('-', 44),
    'Name:     ' . $name,
    'Company:  ' . $company,
    'Email:    ' . $email,
    'Phone:    ' . ($phone !== '' ? $phone : '—'),
    'Sector:   ' . $sector,
    'Service:  ' . $serviceLabel,
    '',
    'Message:',
    $message,
    '',
    str_repeat('-', 44),
    'Sent ' . gmdate('Y-m-d H:i') . ' UTC from ' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown IP'),
]);

$headers = implode("\r\n", [
    'From: ' . address(SITE_NAME . ' Website', FROM_ADDRESS),
    'Reply-To: ' . address($name, $email),
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
    'X-Mailer: PHP/' . PHP_VERSION,
]);

$sent = mail(
    RECIPIENT,
    mb_encode_mimeheader($subject, 'UTF-8'),
    $body,
    $headers,
    '-f' . FROM_ADDRESS
);

if (!$sent) {
    error_log('[contact.php] mail() failed for enquiry from ' . $email);
    respond(false, 'Sorry, your request could not be sent. Please email us directly at ' . RECIPIENT . '.', 500);
}

respond(true);
