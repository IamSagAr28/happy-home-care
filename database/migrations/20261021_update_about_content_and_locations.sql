-- Apply once to an existing installation to publish the approved About Us copy
-- and the confirmed Greenwood, Indiana office listing.
-- Only the original sample locations from the starter schema are hidden.
UPDATE locations
SET active = 0
WHERE (state = 'Texas' AND city = 'Austin' AND address = '2401 E 6th St, Suite 310')
   OR (state = 'California' AND city = 'Los Angeles' AND address = '8550 Wilshire Blvd, Suite 220')
   OR (state = 'Florida' AND city = 'Miami' AND address = '1450 Brickell Ave, Suite 1800');

INSERT INTO locations (state, city, address, zip_code, phone, hours, active)
VALUES ('Indiana', 'Greenwood', '749 Commerce Pkwy Suite B', '46143', '+91 81440 01842', 'Every day · 24/7 support', 1)
ON DUPLICATE KEY UPDATE
  address = VALUES(address),
  zip_code = VALUES(zip_code),
  phone = VALUES(phone),
  hours = VALUES(hours),
  active = VALUES(active);
