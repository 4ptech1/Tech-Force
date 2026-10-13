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
        ├── logo-mark.png / logo-mark-light.png      TF monogram (header / footer)
        ├── hero-industrial-1920.webp / -960.webp     Fallback for the home hero
        ├── services-header-1920.webp / -960.webp     Fallback for the services header
        ├── og-image.jpg            Preview image for WhatsApp/LinkedIn shares
        ├── apple-touch-icon.png
        └── favicon-64.png
```

### Adding the consulting photos

The pages already point at seven photos that **you add whenever you're ready**. Until a file exists, the site falls back gracefully:

- The hero and the services header show the existing plant photo.
- Each sector card shows a navy blueprint panel with a sector icon. It's designed to look finished, so the photos are optional.

To add a photo, save it in `assets/images/` with **exactly** the filename below, then push or upload it. No code changes are needed.

| Filename | Where it appears | Suggested scene | Size |
|---|---|---|---|
| `consulting-hero-boardroom.jpg` | Home hero (behind text, darkened) | Indian engineering consultants reviewing technical blueprints in a corporate meeting room | 1920 × 1080 |
| `consulting-lab-metallurgy.jpg` | Services page header | Consultants examining metallurgical reports in a modern engineering lab | 1920 × 1080 |
| `consulting-meeting-oil-gas.jpg` | Oil & Gas card | Reviewing pipeline weld inspection reports in a meeting room | 1200 × 675 |
| `consulting-meeting-defence.jpg` | Defence card | Examining metallurgical test reports in a modern lab | 1200 × 675 |
| `consulting-meeting-aerospace.jpg` | Aerospace card | Discussing fractography results for an aerospace component | 1200 × 675 |
| `consulting-meeting-railways.jpg` | Railways card | Reviewing bogie-frame welding blueprints | 1200 × 675 |
| `consulting-meeting-transportation.jpg` | Transportation card | Discussing vehicle chassis failure diagnostics around a conference table | 1200 × 675 |

Tips:

- **Landscape 16:9.** Keep faces and key details away from the bottom-left of sector photos, because the sector name sits there.
- **Compress before uploading:** aim for under 300 KB for the hero and header, and under 150 KB for each card (squoosh.app, "MozJPEG", quality about 75).
- **Make each sector recognisable.** Include a sector cue in every shot: a pipeline drawing, an aircraft part, a bogie drawing, a truck chassis. Otherwise five meeting-room photos look identical.
- **Don't caption AI-generated people as your team.** The alt text describes them as consultants in a meeting, which is accurate; don't add "Meet our engineers" style labels.

---

## ✅ Before going live (10-minute checklist)

1. **Create the mailbox** `info@techforceconsulting.com` in **hPanel → Emails**.
   - The form sends from and to this address. Hostinger only delivers PHP mail when the "From" address is a real mailbox on your domain.
   - To use a different address, edit `RECIPIENT` and `FROM_ADDRESS` at the top of `contact.php`, and update the email shown in both HTML pages.
2. **Check the copy against what you actually offer.**
   - This applies especially to the standards listed (ASME IX, API 1104, AWS D17.1, EN 15085, BS 7910, NACE MR0175, RDSO and so on), the testing methods (SEM, eddy current and so on) and advanced joining (laser, electron-beam, fitness-for-purpose assessment).
   - Remove anything you can't deliver yourself or through a partner lab.
3. **Image rights:** the two refinery photos (the hero and services-header fallbacks) look like stock photos. Make sure you hold a licence for them, or replace them by adding the consulting photos above.
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
