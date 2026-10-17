# Tech Force Consulting Engineers — Website

The static two-page website for **[www.techforceconsulting.com](https://www.techforceconsulting.com)**, hosted on Hostinger.

- **No build step.** It's plain HTML, CSS and JavaScript, so whatever is in this repo is exactly what goes live.
- **Two pages:** `index.html` (home, sectors and value proposition) and `services.html` (capabilities, process and the RFQ form).
- **Contact form:** `contact.php` emails each enquiry using Hostinger's built-in PHP mail. You don't need a third-party form service.
- **No third-party requests.** Fonts, images and scripts are all served from your own domain, which makes pages faster and means nothing tracks your visitors.

---

## File layout

```
/                          ← this folder becomes public_html
├── index.html             Home: hero, 5 industry sectors, 2 core disciplines, why us, CTA
├── services.html          Failure analysis + welding deep-dives, 4-step process, Contact/RFQ form
├── contact.php            Form handler (emails enquiries)
├── .htaccess              Security headers, caching, www redirect, hides .git/README
├── robots.txt
├── sitemap.xml
├── favicon.ico
└── assets/
    ├── css/styles.css     All styling (brand colours are at the top as variables)
    ├── js/main.js         Mobile menu, form submission, small helpers
    ├── fonts/             IBM Plex Sans & Mono (self-hosted, open-source licence)
    └── images/
        ├── logo-full.png                             Full logo + tagline (header, and the logo shown by Google)
        ├── logo-full-light.png                       Full logo + tagline (footer, on navy)
        ├── hero-collage-2400.webp                    Home banner collage (desktop)
        ├── hero-collage-mobile-800/1200.webp         Home banner collage (phones: right-hand part)
        ├── services-header-refinery.webp             Services page header background
        ├── sector-<sector>.webp                      Sector card photos (oil-gas, defence, aerospace, railways)
        ├── consulting-meeting-transportation.jpg     Automotive & Transport card photo
        ├── og-image.jpg            Branded preview card for WhatsApp/LinkedIn shares
        ├── apple-touch-icon.png
        └── favicon-64.png
```

### Header

The header shows the full logo, tagline included, at the top of every page. Once a visitor scrolls, it slims to a 72 px bar with the same logo, smaller. The tagline also appears as readable text above the home-page headline.

### Photos

The banner collage, the services header and four of the sector photos come from the "Assignments" reference images you supplied. You confirmed you own them or are licensed to use them commercially. All of them share one colour treatment: even exposure, slightly softer colour, and shadows tinted towards the brand navy.

| File | Where it appears | Made from |
|---|---|---|
| `hero-collage-2400.webp` | Home banner, behind the headline | Offshore platform (R-1), refinery piping (R-5), rail, aerospace and defence panels (Gemini image), refinery columns (R-4), jet engine (2.jpg) |
| `hero-collage-mobile-*.webp` | Home banner on phones | The right-hand part of the same collage |
| `services-header-refinery.webp` | Services page header (darkened) | Refinery piping (R-5) |
| `sector-oil-gas.webp` | Oil & Gas card | Offshore platform (R-1) |
| `sector-defence.webp` | Defence card | Armoured vehicle (4.jpg) |
| `sector-aerospace.webp` | Aerospace card | Jet engine inspection (Gemini image) |
| `sector-railways.webp` | Railways card | Wheelset ultrasonic testing (Gemini image) |
| `consulting-meeting-transportation.jpg` | Automotive & Transport card | Earlier AI-generated image; there was no automotive reference photo |

- **On desktop**, the left part of the banner sits under a dark overlay behind the headline. The clearly visible tiles are on the right: refinery, jet engine and the defence weld inspection.
- **To replace a photo,** save the new one over the file with the same name. Use WebP, landscape 16:9 for sector cards (about 960 × 540), and keep faces and key details away from the bottom-left, where the sector name sits. If a sector photo ever goes missing, its card shows a navy blueprint panel instead of a broken image.
- **Defence card:** the source photo (4.jpg) is only 738 px wide, so it's a little soft on high-resolution screens. A larger version would help.
- **Automotive & Transport card:** this is still the earlier meeting-room image. A photo of a vehicle chassis, an axle or a weld line would match the other cards better.
- **People in the Gemini image are AI-generated.** The alt text describes what they're doing, which is accurate. Don't caption them as your team.
- **Never include** classified-looking stamps or real company logos.

### Brand kit (`brand/`)

Logo files with the tagline *"Experts in Failure Analysis & Welding Technology"*, for letterheads, visiting cards, proposals, email signatures and social profiles:

| File | Use it on |
|---|---|
| `tech-force-logo-tagline.png` | White or light backgrounds (transparent PNG) |
| `tech-force-logo-tagline-dark.png` | Navy or dark backgrounds (transparent PNG) |
| `tech-force-logo-tagline-square-white.png` | Profile pictures, WhatsApp DP, documents (2000 × 2000) |
| `tech-force-logo-tagline-square-navy.png` | LinkedIn and other social profiles (2000 × 2000) |

All four are made from the approved logo artwork (italic tagline under a thin cerulean rule), redrawn in the exact brand navy and cerulean on a clean transparent background. Keep it at least about 40 mm wide in print so the tagline stays readable.

---

## ✅ Before going live (10-minute checklist)

1. **Create the mailboxes** `info@techforceconsulting.com` and `shivansh@techforceconsulting.com` in **hPanel → Emails**. Both appear on the site; the contact form delivers to `info@`.
   - The form sends from and to this address. Hostinger only delivers PHP mail when the "From" address is a real mailbox on your domain.
   - To use a different address, edit `RECIPIENT` and `FROM_ADDRESS` at the top of `contact.php`, and update the email shown in both HTML pages.
2. **Check the copy against what you actually offer.**
   - This applies especially to the standards listed (ASME IX, API 1104, AWS D17.1, EN 15085, BS 7910, NACE MR0175, RDSO and so on), the testing methods (SEM, eddy current and so on) and advanced joining (laser, electron-beam, fitness-for-purpose assessment).
   - Remove anything you can't deliver yourself or through a partner lab.
3. **Images:** the photos come from the reference set you supplied and confirmed you're licensed to use (see *Photos* above). Don't add document stamps, client logos or "classified" markings to any replacement.
4. **Contact details:** consider adding a phone number and city to the footer and contact section. Indian B2B buyers often call first.

---

## Method A: Manual upload (hPanel File Manager)

Best for a one-off launch or when you don't want to use Git.

1. **Create a ZIP** of the *contents* of this folder (not the folder itself):
   - **Windows:** open the folder, select everything (`Ctrl+A`, and make sure hidden files are visible so `.htaccess` is included), then right-click → **Send to → Compressed (zipped) folder**.
   - **Mac / Linux:** run `zip -r site.zip . -x ".git/*" "README.md"` from inside the folder.
2. Log in to **hPanel**, go to **Websites**, and click **Manage** next to `techforceconsulting.com`.
3. Open **Files → File Manager**, then open the **`public_html`** folder.
4. **Delete Hostinger's placeholder files** such as `default.php` (and any old `index.php`).
5. Click **Upload** (the up-arrow icon), choose `site.zip`, and wait for it to finish.
6. Right-click `site.zip` → **Extract**. Make sure the destination is `public_html` itself, *not* a new subfolder.
   - `index.html` must sit directly inside `public_html/`.
7. Delete `site.zip` from the server.
8. Visit `https://www.techforceconsulting.com` and hard-refresh (`Ctrl+F5`).

**To update later:** upload only the changed files over the old ones. If you changed `styles.css` or `main.js`, see *Editing tips* below.

---

## Method B: Git auto-deploy (push to `main` → site updates)

Best for ongoing edits: every push to `main` updates the live site automatically.

### 1. Put the code on GitHub

This repo already lives at `github.com/4ptech1/Tech-Force`, and the finished site is on the **`main`** branch.

> One-time tidy-up: on GitHub, go to **Settings → General → Default branch** and set it to `main`.

*Starting from scratch elsewhere?*

```bash
git init
git add .
git commit -m "Initial website"
git branch -M main
git remote add origin https://github.com/<your-account>/<repo>.git
git push -u origin main
```

### 2. Connect the repo in Hostinger

1. In hPanel: **Websites → Manage** (techforceconsulting.com) → **Advanced → GIT**.
2. **`public_html` must be empty** before the first deploy. Delete `default.php` and any other files in it using File Manager.
3. Under **Create a New Repository**, fill in:
   - **Repository:**
     - Public repo: `https://github.com/4ptech1/Tech-Force.git`
     - Private repo: `git@github.com:4ptech1/Tech-Force.git` (see step 4)
   - **Branch:** `main`
   - **Directory:** leave **empty**, so it deploys straight into `public_html`
4. **Private repo only:** copy the **SSH key** that hPanel shows on the GIT page. Then, on GitHub, go to **repo → Settings → Deploy keys → Add deploy key**, paste the key, and leave "write access" unticked.
5. Click **Create**, then **Deploy**. Your site is now live from Git.

### 3. Turn on auto-deployment

1. On the same hPanel GIT page, find your repository in the list and click **Auto Deployment**. Copy the **Webhook URL** it shows.
2. On GitHub, go to **repo → Settings → Webhooks → Add webhook**:
   - **Payload URL:** paste the Hostinger webhook URL
   - **Content type:** `application/json`
   - **Which events:** *Just the push event*
   - Click **Add webhook**.
3. Test it: make a small edit, then `git commit` and `git push origin main`. The live site should update within a minute.
   - You can also check GitHub → Webhooks → *Recent Deliveries*, which should show a green tick.

> The `.htaccess` file blocks public access to the `.git` folder and this README, which Git deploy places inside `public_html`.

---

## After the first deploy

- **SSL:** in hPanel go to **Security → SSL**, make sure the free SSL is active, and turn on **Force HTTPS**.
- **Test the form:** submit a test enquiry on `services.html#contact` and check that it arrives in the inbox (also check Spam the first time).
- **Google:** add the site to [Google Search Console](https://search.google.com/search-console) and submit `https://www.techforceconsulting.com/sitemap.xml`.
- **Google Business Profile:** free, and very effective for "failure analysis consultant near me" type searches.

---

## Editing tips

- **Text:** edit `index.html` or `services.html` directly. Every section is labelled with a comment, for example `<!-- Sectors -->`.
- **Colours:** change the variables at the top of `assets/css/styles.css`. `--navy` and `--cyan` are sampled from the logo.
- **After editing CSS or JS:** bump the version number in **both** HTML files so visitors don't see a cached copy. For example, change `styles.css?v=1` to `styles.css?v=2`, and do the same for `main.js?v=1`.
- **Spam:** the form has a hidden "honeypot" field that catches most bots. If spam still gets through, adding Cloudflare Turnstile (free) is the next step.
- **Preview locally:** double-click `index.html` to open it in a browser.
  - The form only works when PHP is running. To test it, run `php -S localhost:8000` in this folder and open `http://localhost:8000`.
