-- Reviewer copy update: revised About Us copy, full resource articles, and all six service descriptions.
-- Apply once to an existing Happy Home Care database after the earlier project migrations.
ALTER TABLE resources ADD COLUMN body MEDIUMTEXT NULL, ADD COLUMN button_label VARCHAR(120) NULL;

INSERT INTO services (title, slug, summary, icon, sort_order) VALUES
('Personal care','personal-care','Help with daily things, with dignity. Some days, you just need a bit of extra help. Our caregivers support your loved ones with daily activities like bathing, grooming, dressing, and moving safely around their home.','☀',1),
('Companion care','companion-care','Good company makes a good day. The presence of our companions brings conversation, activities and friendliness—all that your loved ones need when they’re feeling lonely.','♡',2),
('Memory care','memory-care','Patience, routine, and a familiar face. We understand how challenging these changes can be for the family. Our caregivers will support your loved ones with consistent daily routines, a safe home environment, gentle and engaging activities, and help with daily tasks.','✿',3),
('Respite care','respite-care','You can rest. We’ve got them. It’s important to take a break as a caregiver. Respite care gives you the time to rest, work, travel or simply recharge, knowing a trusted professional is taking care of your loved one for anywhere from a few hours to a few weeks. We support you with short breaks, planned time away and last-minute care assistance.','⌂',4),
('Recovery at home','recovery-at-home','That means you’ll have access to our recovery team while you heal at home. We help with the everyday support that makes those first weeks safer and easier, working alongside your loved ones’ care team, including help moving around safely, meals and hydration, and medication reminders.','✚',5),
('24-hour care','24-hour-care','A professional caregiver is always there! When needs go beyond a few hours, around-the-clock care gives constant support, including overnight and live-in options, so your family can rest easier. Including overnight assistance · help at any hour · live-in options · a consistent caregiver team · safety and supervision','◷',6)
ON DUPLICATE KEY UPDATE summary = VALUES(summary), sort_order = VALUES(sort_order);

UPDATE resources SET published = 0 WHERE title IN (
  'Early signs of memory changes families should know',
  'Talking with a parent about getting a little help',
  'Making space for yourself while caring for someone else'
);

INSERT INTO resources (category, title, summary, body, button_label, read_time, icon, published) VALUES
('Family guide','What Medicare won’t cover, and what to do about it','Understand the difference between skilled care Medicare may cover and long-term personal care, plus options families can explore.','“Mom had a fall; can I call someone for her?”

“What about my dad? Can he get help dressing?”

You know they expect Medicare will cover those services. And you would too if you were sitting with them, but this is one of our most common surprises. We’ll talk about what isn’t covered, and how to handle these situations when you are facing them.

Medicare may cover skilled care at home, like part-time nursing or therapy, when a doctor orders it after an illness, injury, or hospital stay.

Medicare doesn’t cover long-term personal care, like help with bathing, dressing, or meals, when that’s the only help needed. And that’s usually the help families need every day.

What are your options?

- Medicaid: If they meet their state’s eligibility requirements
- Long term care insurance: If your parents have a policy.
- VA benefits: For eligible veterans
- Private pay.','','2 min read','✿',1),
('Health care decisions','Health care decisions','Plan ahead for who can speak with a parent’s bank or doctor if they cannot make decisions themselves.','If Mom couldn’t make decisions tomorrow, who could talk to her bank or her doctor?

Most families have never asked that question until they must. A Power of Attorney is how you answer it ahead of time, and it’s simpler than it sounds.

What is a Power of Attorney?

It’s a legal document where your parent (the “principal”) chooses someone they trust (the “agent”) to act on their behalf. Think of it as saying, “If I can’t handle this, I want you to …”

Two things families often mix up:

Financial power of attorney. This allows your agent to manage financial issues such as paying bills, managing accounts and dealing with property.

Health care decisions. These are handled differently by most people—you designate a health care representative in your advance directive. That’s the person who would speak for your parents when he or she is unable to do it themselves.','How to start?','4 min read','✚',1),
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

Need a hand? Talk to us. We’ll help you figure out what kind of support would make the biggest difference for your family.','Talk to us','Self-care guide','☼',1)
ON DUPLICATE KEY UPDATE category = VALUES(category), summary = VALUES(summary), body = VALUES(body), button_label = VALUES(button_label), read_time = VALUES(read_time), icon = VALUES(icon), published = 1;
