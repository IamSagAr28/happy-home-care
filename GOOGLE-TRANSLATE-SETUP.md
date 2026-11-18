# Turn on Google Translate

Google Cloud requires an API key and a billing account. Translation usage may incur charges; see Google's current [Cloud Translation pricing](https://cloud.google.com/products/translate/pricing).

## 1. Create and restrict the key

1. Sign in to Google Cloud Console and select or create a project.
2. Enable **Cloud Translation API** for that project.
3. Create an API key in **APIs & Services → Credentials**.
4. Restrict the key to **Cloud Translation API**. If HostingRaja provides a stable outbound server IP, apply an IP restriction too.

The site keeps this key server-side. Do not put it in an HTML file or in `public/`.

## 2. Add the key on your Mac

1. In Terminal, go to the project folder.
2. If you have not created the private configuration yet, run `cp .env.example .env`.
3. Open `.env` in a text editor and set `GOOGLE_TRANSLATE_API_KEY=your-key`.
4. Confirm PHP cURL is enabled (`php -m` should list `curl`).
5. Restart the local PHP server and choose Punjabi, Hindi, or Spanish in the site language selector.

## 3. Add the key on HostingRaja

1. In cPanel File Manager, open your account home directory (beside `public_html`).
2. Edit the private `.env` file outside `public_html`.
3. Add `GOOGLE_TRANSLATE_API_KEY=your-key` and save.
4. In cPanel's PHP extension settings, enable cURL if it is not already enabled.
5. Confirm the hosting server can make outbound HTTPS requests to `translation.googleapis.com`.
6. Visit the website, select another language, and check the page text.

No database migration is needed for the logo or translation changes.
