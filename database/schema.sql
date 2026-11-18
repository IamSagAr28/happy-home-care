CREATE DATABASE IF NOT EXISTS happy_home_care CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE happy_home_care;

CREATE TABLE IF NOT EXISTS admins (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, email VARCHAR(190) NOT NULL UNIQUE, password_hash VARCHAR(255) NOT NULL, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS members (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, name VARCHAR(120) NOT NULL, email VARCHAR(190) NOT NULL UNIQUE, password_hash VARCHAR(255) NULL, google_id VARCHAR(255) NULL UNIQUE, facebook_id VARCHAR(255) NULL UNIQUE, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS settings (setting_key VARCHAR(100) PRIMARY KEY, setting_value TEXT NOT NULL) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS services (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, title VARCHAR(160) NOT NULL, slug VARCHAR(180) NOT NULL UNIQUE, summary TEXT NOT NULL, icon VARCHAR(20) DEFAULT '♡', sort_order INT NOT NULL DEFAULT 0, active TINYINT(1) NOT NULL DEFAULT 1, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS locations (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, state VARCHAR(100) NOT NULL, city VARCHAR(100) NOT NULL, address VARCHAR(220) NOT NULL, zip_code VARCHAR(20) NOT NULL, phone VARCHAR(40) NOT NULL, hours VARCHAR(120) NOT NULL DEFAULT 'Every day · 24/7 support', active TINYINT(1) NOT NULL DEFAULT 1, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, INDEX location_search (state, city, zip_code), UNIQUE KEY location_unique (state, city)) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS resources (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, category VARCHAR(100) NOT NULL, title VARCHAR(220) NOT NULL, summary TEXT NOT NULL, body MEDIUMTEXT NULL, button_label VARCHAR(120) NULL, read_time VARCHAR(40) DEFAULT '5 min read', icon VARCHAR(20) DEFAULT '✿', published TINYINT(1) NOT NULL DEFAULT 1, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, UNIQUE KEY resource_title (title)) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS faqs (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, question VARCHAR(240) NOT NULL, answer TEXT NOT NULL, sort_order INT NOT NULL DEFAULT 0, active TINYINT(1) NOT NULL DEFAULT 1, UNIQUE KEY faq_question (question)) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS testimonials (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, customer_name VARCHAR(120) NOT NULL, location VARCHAR(120) NOT NULL, quote TEXT NOT NULL, rating TINYINT UNSIGNED NOT NULL DEFAULT 5, active TINYINT(1) NOT NULL DEFAULT 1, UNIQUE KEY testimonial_person (customer_name, location)) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS caregivers (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, full_name VARCHAR(160) NOT NULL, role VARCHAR(140) NOT NULL, experience VARCHAR(80) NOT NULL, specialties VARCHAR(220) NOT NULL, photo_url VARCHAR(500) DEFAULT '', active TINYINT(1) NOT NULL DEFAULT 1, UNIQUE KEY caregiver_name (full_name)) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS inquiries (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, phone VARCHAR(40) NOT NULL, email VARCHAR(190) NOT NULL, zip_code VARCHAR(20) NOT NULL, care_type VARCHAR(100) NOT NULL, details TEXT NULL, status ENUM('new','contacted','closed') NOT NULL DEFAULT 'new', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, INDEX inquiries_status (status, created_at)) ENGINE=InnoDB;
CREATE TABLE IF NOT EXISTS applications (id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, email VARCHAR(190) NOT NULL, role VARCHAR(140) NOT NULL, status ENUM('new','reviewing','contacted','closed') NOT NULL DEFAULT 'new', created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, INDEX applications_status (status, created_at)) ENGINE=InnoDB;

INSERT IGNORE INTO settings (setting_key,setting_value) VALUES
('site_name','HAPPY HOME CARE'),('phone','+91 81440 01842'),('phone_link','918144001842'),('email','mail2rakeshpandit@gmail.com'),('hero_title','Elevated Care. Right at Home.'),('hero_intro','Compassionate, professional in-home care for seniors and adults. We make it easier to live safely, comfortably, and happily at home.');
INSERT IGNORE INTO services (title,slug,summary,icon,sort_order) VALUES
('Personal care','personal-care','Help with daily things, with dignity. Some days, you just need a bit of extra help. Our caregivers support your loved ones with daily activities like bathing, grooming, dressing, and moving safely around their home.','☀',1),
('Companion care','companion-care','Good company makes a good day. The presence of our companions brings conversation, activities and friendliness—all that your loved ones need when they’re feeling lonely.','♡',2),
('Memory care','memory-care','Patience, routine, and a familiar face. We understand how challenging these changes can be for the family. Our caregivers will support your loved ones with consistent daily routines, a safe home environment, gentle and engaging activities, and help with daily tasks.','✿',3),
('Respite care','respite-care','You can rest. We’ve got them. It’s important to take a break as a caregiver. Respite care gives you the time to rest, work, travel or simply recharge, knowing a trusted professional is taking care of your loved one for anywhere from a few hours to a few weeks. We support you with short breaks, planned time away and last-minute care assistance.','⌂',4),
('Recovery at home','recovery-at-home','That means you’ll have access to our recovery team while you heal at home. We help with the everyday support that makes those first weeks safer and easier, working alongside your loved ones’ care team, including help moving around safely, meals and hydration, and medication reminders.','✚',5),
('24-hour care','24-hour-care','A professional caregiver is always there! When needs go beyond a few hours, around-the-clock care gives constant support, including overnight and live-in options, so your family can rest easier. Including overnight assistance · help at any hour · live-in options · a consistent caregiver team · safety and supervision','◷',6);
INSERT IGNORE INTO locations (state,city,address,zip_code,phone) VALUES ('Indiana','Greenwood','749 Commerce Pkwy Suite B','46143','+91 81440 01842');
INSERT IGNORE INTO resources (category,title,summary,body,button_label,read_time,icon) VALUES
('Family guide','What Medicare won’t cover, and what to do about it','Understand the difference between skilled care Medicare may cover and long-term personal care, plus options families can explore.','“Mom had a fall; can I call someone for her?”

“What about my dad? Can he get help dressing?”

You know they expect Medicare will cover those services. And you would too if you were sitting with them, but this is one of our most common surprises. We’ll talk about what isn’t covered, and how to handle these situations when you are facing them.

Medicare may cover skilled care at home, like part-time nursing or therapy, when a doctor orders it after an illness, injury, or hospital stay.

Medicare doesn’t cover long-term personal care, like help with bathing, dressing, or meals, when that’s the only help needed. And that’s usually the help families need every day.

What are your options?

- Medicaid: If they meet their state’s eligibility requirements
- Long term care insurance: If your parents have a policy.
- VA benefits: For eligible veterans
- Private pay.','','2 min read','✿'),
('Health care decisions','Health care decisions','Plan ahead for who can speak with a parent’s bank or doctor if they cannot make decisions themselves.','If Mom couldn’t make decisions tomorrow, who could talk to her bank or her doctor?

Most families have never asked that question until they must. A Power of Attorney is how you answer it ahead of time, and it’s simpler than it sounds.

What is a Power of Attorney?

It’s a legal document where your parent (the “principal”) chooses someone they trust (the “agent”) to act on their behalf. Think of it as saying, “If I can’t handle this, I want you to …”

Two things families often mix up:

Financial power of attorney. This allows your agent to manage financial issues such as paying bills, managing accounts and dealing with property.

Health care decisions. These are handled differently by most people—you designate a health care representative in your advance directive. That’s the person who would speak for your parents when he or she is unable to do it themselves.','How to start?','4 min read','✚'),
('Caregiver wellness','Caring for your parents shouldn’t mean losing yourself','Caring for someone you love can take over your day. These ideas can help you make room for your own needs too.','When was the last time someone asked how you’re doing?

Caring for someone you love can quietly take over everything else, and making a little space for yourself isn’t selfish. It’s how you keep caring for them, at a pace you can sustain.

Why this matters

If you’re tired, you’re not failing. You’re human. Caring for someone you love is a lot, and you’ve probably been doing most of it quietly. Looking after yourself isn’t stepping back. It’s how you keep showing up for them.

Small ways to find your pace:

- Ask for help and be specific. “Can you take Mom to her appointment on Thursday?” gets a better answer than “Let me know if you can help.”
- Share the load. Siblings, cousins, neighbors, and friends often want to help but don’t know how. Give them one small, clear task.
- Protect a little time. Even 20 minutes for a walk, a call with a friend, or a quiet coffee counts.
- Keep up with your own health. Your checkups and your rest matter too, even when it feels like there’s no time.
- Let someone else carry part of it. Bringing help isn’t giving up. It’s how many families make care last, and it gives you room to be a daughter or son again, not only a caregiver.

A gentle reminder

If you feel exhausted, overwhelmed, or hopeless for more than a few days, talk to your doctor or a mental health professional. You deserve support too.

Need a hand? Talk to us. We’ll help you figure out what kind of support would make the biggest difference for your family.','Talk to us','Self-care guide','☼');
INSERT IGNORE INTO faqs (question,answer,sort_order) VALUES ('What kinds of in-home care do you offer?','We offer personal and companion care, dementia support, respite care, recovery assistance, medication reminders, and around-the-clock care. We will help you figure out what fits your family’s needs.',1),('How much does home care cost?','Cost depends on the type and schedule of care. We offer a free assessment and a clear, personalized estimate, and can help you explore potential benefits and coverage.',2),('How soon can care begin?','When care is urgent, we do our best to arrange support within 24–48 hours. Most planned care can begin within a few days of your assessment.',3),('Are caregivers screened and insured?','Caregivers complete background and reference checks, skills assessments, and ongoing training. Our care team can walk you through our standards.',4),('Can we change the care plan later?','Absolutely. We check in with families and adjust the schedule and care plan as needs or preferences change.',5);
INSERT IGNORE INTO testimonials (customer_name,location,quote,rating) VALUES ('James R.','Austin, TX','We finally sleep at night knowing Mom is in good hands. Her caregiver is patient, warm, and thoughtful.',5),('Sarah P.','Phoenix, AZ','The personal touch makes all the difference. They really listened and found someone who loves gardening just like Dad.',5),('Diane K.','Seattle, WA','Respite care let my husband and me take our first trip in years. We were able to truly relax.',5);
INSERT IGNORE INTO caregivers (full_name,role,experience,specialties) VALUES ('Sarah Mitchell','Senior Care Specialist','8 years experience','Memory care, Personal care'),('Marcus Johnson','Home Health Aide','5 years experience','Companion care, Recovery'),('Elena Rodriguez','Certified Nursing Assistant','12 years experience','Nursing support, Memory care');
