# HAPPY HOME CARE website

A PHP 8 and MySQL website with a public home-care site, database-backed content, working enquiry and caregiver application forms, and an authenticated admin area. The app uses PHP's PDO extension and has no Composer dependencies.

## Version 2 refresh and run instructions

The refreshed site uses the approved logo and tagline artwork with transparent backgrounds so they sit naturally on page surfaces, the supplied photos, and the existing palette (`#00466e`, `#45d7ca`, `#ffb11e`, and white). The visual layout follows the client-approved reference: a clean sticky header, spacious image-led home page, rounded service and content cards, and fixed Request Care, WhatsApp, and Call actions. The About Us section now includes the supplied mission, vision, and five core values, followed by a Core Team introduction. The confirmed Greenwood, Indiana office and Arizona coming-soon notice appear in Locations. The content is maintained separately in `app/about_content.php`. The site also has email/password customer signup and sign-in plus Google and Facebook OAuth entry points, hides Care Finder and Caregiver sections from the public homepage, adds English/Punjabi/Hindi/Spanish interface choices, and updates call, WhatsApp, and Gmail links. The customer accounts add one small `members` table; existing admin, inquiry, and content tables remain intact.

For a new local installation, extract the project package and:

1. Install PHP 8.1+ and MySQL 8+ if needed (`brew install php mysql`); ensure `pdo_mysql` is enabled.
2. In Terminal, change to the extracted project folder. Copy `.env.example` to `.env` and enter your local database name, username, and password. Keep `.env` in the project root.
3. Create the database tables by importing `database/schema.sql` in phpMyAdmin or the MySQL command line. For an existing database, import `database/migrations/20261020_add_members_and_update_contact.sql` if customer accounts are not installed yet, then import `database/migrations/20261021_update_about_content_and_locations.sql`. Do not re-import the full schema over existing data.
4. Create the first admin account with `php bin/create_admin.php "Site Admin" you@example.com`; choose a strong password when prompted.
5. Start the site from the project folder with `php -S 127.0.0.1:8000 -t public`.
6. Open `http://127.0.0.1:8000` for the website or `http://127.0.0.1:8000/admin/login.php` for the admin panel.

For HostingRaja, use the cPanel database and deployment guide in [HOSTINGRAJA_DEPLOYMENT.md](HOSTINGRAJA_DEPLOYMENT.md). Customer Google/Facebook sign-in needs provider credentials in the private `.env` file and PHP cURL enabled. Admin sign-in remains separate at `/admin/login.php` and uses the admin email and password.

## What's included

- Responsive public homepage using the attached approved SVG logo/tagline and the supplied azure, turquoise, orange, and white palette.
- MySQL-backed services, locations, resources, FAQs, testimonials, caregiver profiles, and contact details.
- Searchable location directory. The public Care Finder and Caregiver profile sections are hidden per the meeting notes; their data remains in the admin/database for later use.
- Care requests and caregiver applications saved to MySQL and visible in the admin panel.
- Admin management for all homepage content, contact details, enquiries, and application status.
- Password-hashed admin accounts, prepared SQL statements, HTML escaping, CSRF tokens, and a separate `.env` configuration file.
- Customer email/password accounts and optional Google/Facebook sign-in, stored in the separate `members` table.
- English, Punjabi, Hindi, and Spanish choices for the navigation, key actions, and account/form interface. CMS-authored service, resource, FAQ, testimonial, and location copy remains as entered by the administrator. The supplied About Us copy is in `app/about_content.php`.
- Direct call and WhatsApp links using `+91 81440 01842`, and email links using `mail2rakeshpandit@gmail.com`.

Instagram is not wired as a general customer sign-in provider: Instagram's login product is designed for professional Instagram accounts, not ordinary website customers. The sign-in page explains this and still offers Google, Facebook, and email/password.

## Requirements for macOS

- macOS with Homebrew installed.
- PHP 8.1 or newer with `PDO`, `pdo_mysql`, and `cURL` enabled (cURL is needed for Google/Facebook sign-in).
- MySQL 8 or newer.

If PHP or MySQL is not already installed on your Mac, Homebrew can install them. Homebrew's MySQL formula documents the install and service commands, and PHP's manual covers macOS packages and PDO MySQL support: [Homebrew MySQL](https://formulae.brew.sh/formula/mysql), [PHP on macOS](https://www.php.net/manual/en/install.macosx.php), [PDO MySQL](https://www.php.net/manual/en/ref.pdo-mysql.php).

## Run locally

Open Terminal and run the following from the project folder.

1. Install PHP and MySQL if they are not already installed:

   ```sh
   brew install php mysql
   ```

   If Homebrew is not installed, follow its current [macOS installation instructions](https://brew.sh/). Installation may ask for your Mac password.

2. Start the local MySQL service:

   ```sh
   brew services start mysql
   ```

   A fresh Homebrew MySQL install starts with a local `root` account and no password. If MySQL is already configured on your Mac, use its existing credentials in the `.env` file in the next step. Avoid installing a second MySQL server if another one is already running.

3. Create the private app configuration file:

   ```sh
   cp .env.example .env
   ```

   Open `.env` in a text editor and set `DB_USER` and `DB_PASSWORD` if your local MySQL credentials differ from the defaults. If your MySQL `root` account has a password, enter it as `DB_PASSWORD`. For better local practice, you can create a dedicated app account using the instructions below. `.env` is excluded from Git and sits outside the `public` web directory.

4. Create the database and add the starter website content:

   ```sh
   mysql -u root < database/schema.sql
   ```

   If your MySQL root account has a password, use `mysql -u root -p < database/schema.sql` and enter it when prompted.

5. Confirm PHP has the MySQL driver enabled:

   ```sh
   php -m | grep -i pdo_mysql
   ```

   You should see `pdo_mysql`. If it is missing, install or enable the matching MySQL extension for your PHP installation.

6. Create an administrator account. The password is typed without showing on screen and must be at least 12 characters:

   ```sh
   php bin/create_admin.php "Site Admin" admin@example.com
   ```

7. Start the website:

   ```sh
   php -S 127.0.0.1:8000 -t public
   ```

8. Open [http://127.0.0.1:8000](http://127.0.0.1:8000) for the public site or [http://127.0.0.1:8000/admin/login.php](http://127.0.0.1:8000/admin/login.php) for the admin panel.

For shared hosting deployment, including the cPanel folder layout, database wizard, SQL import, production `.env`, domain, and SSL steps, see [HOSTINGRAJA_DEPLOYMENT.md](HOSTINGRAJA_DEPLOYMENT.md). Use `database/schema-hosting.sql` when importing into a database created in cPanel.

Keep the terminal window running while you use the local site. Press **Control-C** to stop the PHP development server. The MySQL service can remain running between sessions; stop it with `brew services stop mysql` when you no longer need it.

## Managing the site

After signing in, use the sidebar to add, edit, publish, and remove services, locations, resources, FAQs, testimonials, and caregiver profiles. Use **Website details** to update the public name, phone number, email, and homepage introduction. New care requests and job applications appear in their respective lists, where their follow-up status can be updated.

Public submissions are stored in the local database. This starter project does not send email or connect to a third-party CRM. Configure a mail service before relying on email notifications or using this site for a live care business.

### If MySQL says “Access denied”

The app's sample configuration assumes a new local Homebrew MySQL installation where `root` has no password. Your MySQL server is rejecting that empty password. Either put the existing MySQL root password in `.env` as `DB_PASSWORD=your-password`, or create a dedicated application account:

```sh
mysql -u root -p
```

At the `mysql>` prompt, replace `Use-A-Long-Unique-Password` with a strong password, then run:

```sql
CREATE USER 'happy_home_app'@'localhost' IDENTIFIED BY 'Use-A-Long-Unique-Password';
CREATE USER 'happy_home_app'@'127.0.0.1' IDENTIFIED BY 'Use-A-Long-Unique-Password';
GRANT ALL PRIVILEGES ON happy_home_care.* TO 'happy_home_app'@'localhost';
GRANT ALL PRIVILEGES ON happy_home_care.* TO 'happy_home_app'@'127.0.0.1';
EXIT;
```

Then update the project `.env`:

```dotenv
DB_HOST=127.0.0.1
DB_NAME=happy_home_care
DB_USER=happy_home_app
DB_PASSWORD=Use-A-Long-Unique-Password
```

Save the file and retry `php bin/create_admin.php "Site Admin" admin@example.com`. Keep `.env` private and do not commit it. The site now shows a direct configuration hint for MySQL credential errors instead of an opaque PDO stack trace.

## Configuration reference

The application reads these values from the private root `.env` file:

| Key | Purpose |
| --- | --- |
| `APP_ENV` | Runtime environment label. |
| `APP_DEBUG` | Enable detailed development errors (`true` locally, `false` on a live server). |
| `APP_URL` | Canonical base URL for the installation. |
| `DB_HOST`, `DB_PORT` | MySQL server connection. |
| `DB_NAME` | Database name (defaults to `happy_home_care`). |
| `DB_USER`, `DB_PASSWORD` | MySQL credentials. |

For a live deployment, use HTTPS, a dedicated database user with access only to this database, a strong unique administrator password, `APP_DEBUG=false`, and a production web server configured to serve only the `public` directory. Back up the database regularly and add email delivery before depending on enquiry forms for business operations.
