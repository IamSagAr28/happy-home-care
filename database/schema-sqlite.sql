CREATE TABLE IF NOT EXISTS admins (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL UNIQUE, password_hash TEXT NOT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS members (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT NOT NULL, email TEXT NOT NULL UNIQUE, password_hash TEXT NULL, google_id TEXT NULL UNIQUE, facebook_id TEXT NULL UNIQUE, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS settings (setting_key TEXT PRIMARY KEY, setting_value TEXT NOT NULL);
CREATE TABLE IF NOT EXISTS services (id INTEGER PRIMARY KEY AUTOINCREMENT, title TEXT NOT NULL, slug TEXT NOT NULL UNIQUE, summary TEXT NOT NULL, icon TEXT DEFAULT '♡', sort_order INTEGER NOT NULL DEFAULT 0, active INTEGER NOT NULL DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS locations (id INTEGER PRIMARY KEY AUTOINCREMENT, state TEXT NOT NULL, city TEXT NOT NULL, address TEXT NOT NULL, zip_code TEXT NOT NULL, phone TEXT NOT NULL, hours TEXT NOT NULL DEFAULT 'Every day · 24/7 support', active INTEGER NOT NULL DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS resources (id INTEGER PRIMARY KEY AUTOINCREMENT, category TEXT NOT NULL, title TEXT NOT NULL UNIQUE, summary TEXT NOT NULL, read_time TEXT DEFAULT '5 min read', icon TEXT DEFAULT '✿', published INTEGER NOT NULL DEFAULT 1, created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS faqs (id INTEGER PRIMARY KEY AUTOINCREMENT, question TEXT NOT NULL UNIQUE, answer TEXT NOT NULL, sort_order INTEGER NOT NULL DEFAULT 0, active INTEGER NOT NULL DEFAULT 1);
CREATE TABLE IF NOT EXISTS testimonials (id INTEGER PRIMARY KEY AUTOINCREMENT, customer_name TEXT NOT NULL, location TEXT NOT NULL, quote TEXT NOT NULL, rating INTEGER NOT NULL DEFAULT 5, active INTEGER NOT NULL DEFAULT 1);
CREATE TABLE IF NOT EXISTS caregivers (id INTEGER PRIMARY KEY AUTOINCREMENT, full_name TEXT NOT NULL UNIQUE, role TEXT NOT NULL, experience TEXT NOT NULL, specialties TEXT NOT NULL, photo_url TEXT DEFAULT '', active INTEGER NOT NULL DEFAULT 1);
CREATE TABLE IF NOT EXISTS inquiries (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name TEXT NOT NULL, last_name TEXT NOT NULL, phone TEXT NOT NULL, email TEXT NOT NULL, zip_code TEXT NOT NULL, care_type TEXT NOT NULL, details TEXT NULL, status TEXT NOT NULL DEFAULT 'new', created_at DATETIME DEFAULT CURRENT_TIMESTAMP);
CREATE TABLE IF NOT EXISTS applications (id INTEGER PRIMARY KEY AUTOINCREMENT, first_name TEXT NOT NULL, last_name TEXT NOT NULL, email TEXT NOT NULL, role TEXT NOT NULL, status TEXT NOT NULL DEFAULT 'new', created_at DATETIME DEFAULT CURRENT_TIMESTAMP);

INSERT OR IGNORE INTO settings (setting_key,setting_value) VALUES
('site_name','HAPPY HOME CARE'),('phone','+91 81440 01842'),('phone_link','918144001842'),('email','mail2rakeshpandit@gmail.com'),('hero_title','Elevated Care. Right at Home.'),('hero_intro','Compassionate, professional in-home care for seniors and adults. We make it easier to live safely, comfortably, and happily at home.');

INSERT OR IGNORE INTO services (title,slug,summary,icon,sort_order) VALUES
('Personal care','personal-care','Gentle help with bathing, dressing, mobility, and daily routines, always with dignity.','☀',1),
('Companion care','companion-care','Good company, meaningful activities, and a friendly presence throughout the day.','♡',2),
('Memory care','memory-care','Patient, specialized Alzheimer’s and dementia support from trained caregivers.','✿',3),
('Respite care','respite-care','A trusted break for family caregivers, from a few hours to a few weeks.','⌂',4),
('Recovery at home','recovery-at-home','A safer, smoother transition home after a hospital stay or surgery.','✚',5),
('24-hour care','24-hour-care','Reliable around-the-clock support, including overnight and live-in care.','◷',6);

INSERT OR IGNORE INTO locations (state,city,address,zip_code,phone,hours,active) VALUES
('Indiana','Greenwood','749 Commerce Pkwy Suite B','46143','+91 81440 01842','Every day · 24/7 support',1);

INSERT OR IGNORE INTO resources (category,title,summary,read_time,icon) VALUES
('Family guide','Early signs of memory changes families should know','Recognizing early changes can help families plan and find the right support. Here are a few things to look for.','8 min read','✿'),
('Care planning','Talking with a parent about getting a little help','A thoughtful conversation can make it easier to explore support together.','6 min read','♡'),
('Caregiver wellness','Making space for yourself while caring for someone else','Simple ways to protect your own wellbeing while supporting someone you love.','5 min read','☼');

INSERT OR IGNORE INTO faqs (question,answer,sort_order) VALUES
('What kinds of in-home care do you offer?','We offer personal and companion care, dementia support, respite care, recovery assistance, medication reminders, and around-the-clock care. We will help you figure out what fits your family’s needs.',1),
('How much does home care cost?','Cost depends on the type and schedule of care. We offer a free assessment and a clear, personalized estimate, and can help you explore potential benefits and coverage.',2),
('How soon can care begin?','When care is urgent, we do our best to arrange support within 24–48 hours. Most planned care can begin within a few days of your assessment.',3),
('Are caregivers screened and insured?','Caregivers complete background and reference checks, skills assessments, and ongoing training. Our care team can walk you through our standards.',4),
('Can we change the care plan later?','Absolutely. We check in with families and adjust the schedule and care plan as needs or preferences change.',5);

INSERT OR IGNORE INTO testimonials (customer_name,location,quote,rating) VALUES
('James R.','Austin, TX','We finally sleep at night knowing Mom is in good hands. Her caregiver is patient, warm, and thoughtful.',5),
('Sarah P.','Phoenix, AZ','The personal touch makes all the difference. They really listened and found someone who loves gardening just like Dad.',5),
('Diane K.','Seattle, WA','Respite care let my husband and me take our first trip in years. We were able to truly relax.',5);

INSERT OR IGNORE INTO caregivers (full_name,role,experience,specialties) VALUES
('Sarah Mitchell','Senior Care Specialist','8 years experience','Memory care, Personal care'),
('Marcus Johnson','Home Health Aide','5 years experience','Companion care, Recovery'),
('Elena Rodriguez','Certified Nursing Assistant','12 years experience','Nursing support, Memory care');
