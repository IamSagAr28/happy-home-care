-- Apply once to an existing installation. Creates only the customer account table
-- and updates the contact details supplied by the project owner.
CREATE TABLE IF NOT EXISTS members (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NULL,
  google_id VARCHAR(255) NULL UNIQUE,
  facebook_id VARCHAR(255) NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO settings (setting_key, setting_value) VALUES
  ('phone', '+91 81440 01842'),
  ('phone_link', '918144001842'),
  ('email', 'mail2rakeshpandit@gmail.com'),
  ('hero_title', 'Elevated Care. Right at Home.')
ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value);
