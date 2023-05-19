PRAGMA foreign_keys = ON;


PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS TICKET_HASHTAGS;
DROP TABLE IF EXISTS MESSAGES;
DROP TABLE IF EXISTS TICKETS;
DROP TABLE IF EXISTS FAQS;
DROP TABLE IF EXISTS ADMINS;
DROP TABLE IF EXISTS AGENTS;
DROP TABLE IF EXISTS CLIENTS;
DROP TABLE IF EXISTS DEPARTMENTS;
DROP TABLE IF EXISTS HASHTAGS;

CREATE TABLE CLIENTS (
client_id INTEGER PRIMARY KEY AUTOINCREMENT,
username VARCHAR(255) NOT NULL,
password VARCHAR(255) NOT NULL,
email VARCHAR(255) NOT NULL
);

CREATE TABLE DEPARTMENTS (
department_id INTEGER PRIMARY KEY AUTOINCREMENT,
department_name VARCHAR(255) NOT NULL
);

CREATE TABLE AGENTS (
agent_id INTEGER PRIMARY KEY AUTOINCREMENT,
client_id INTEGER NOT NULL,
department_id INTEGER,
FOREIGN KEY(client_id) REFERENCES CLIENTS(client_id),
FOREIGN KEY(department_id) REFERENCES DEPARTMENTS(department_id)
);

CREATE TABLE ADMINS (
admin_id INTEGER PRIMARY KEY AUTOINCREMENT,
client_id INTEGER NOT NULL,
agent_id INTEGER NOT NULL,
FOREIGN KEY(agent_id) REFERENCES AGENTS(agent_id)
);

CREATE TABLE FAQS (
faq_id INTEGER PRIMARY KEY AUTOINCREMENT,
department_id INTEGER NOT NULL,
question VARCHAR(255) NOT NULL,
answer VARCHAR(255),
FOREIGN KEY(department_id) REFERENCES DEPARTMENTS(department_id)
);

CREATE TABLE TICKETS (
ticket_id INTEGER PRIMARY KEY AUTOINCREMENT,
agent_id INTEGER,
client_id INTEGER NOT NULL,
department_id INTEGER NOT NULL,
status VARCHAR(255) CHECK( status IN ('Open','Closed','Not Assigned') ) NOT NULL,
title VARCHAR(255) NOT NULL,
FOREIGN KEY(department_id) REFERENCES DEPARTMENTS(department_id),
FOREIGN KEY(client_id) REFERENCES CLIENTS(client_id),
FOREIGN KEY(agent_id) REFERENCES AGENTS(agent_id)
);

CREATE TABLE MESSAGES (
message_id INTEGER PRIMARY KEY AUTOINCREMENT,
ticket_id INTEGER NOT NULL,
message_content VARCHAR(255) NOT NULL,
date_created TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
client_id INTEGER NOT NULL,
FOREIGN KEY(ticket_id) REFERENCES TICKETS(ticket_id),
FOREIGN KEY(client_id) REFERENCES CLIENTS(client_id)
);

CREATE TABLE HASHTAGS (
hashtag_id INTEGER PRIMARY KEY AUTOINCREMENT,
hashtag_name VARCHAR(255) NOT NULL
);

CREATE TABLE TICKET_HASHTAGS (
ticket_id INTEGER NOT NULL,
hashtag_id INTEGER NOT NULL,
PRIMARY KEY (ticket_id, hashtag_id),
FOREIGN KEY(ticket_id) REFERENCES TICKETS(ticket_id),
FOREIGN KEY(hashtag_id) REFERENCES HASHTAGS(hashtag_id)
);

INSERT INTO CLIENTS (username, password, email)
VALUES
    ('John Smith', '$2y$10$ajaejfDUBmln6DoEAsgC3u9WT9oB2VYkx93gEsyEUMhLiL7FbHeO6', 'john@example.com'),
    ('Jane Johnson', '$2y$10$cfsvf2mqM788C1EK8J.2h.VpdY7L/E/aTBapRUrRnM/z.kk9StRQy', 'jane@example.com'),
    ('Bob Brown', '$2y$10$CVpJIJ86eRNo4IlcVvbQeOwCnJBJHdIZljKw/eBD0uSPwsq0nUrfy', 'bob@example.com'),
    ('Sara Davis', '$2y$10$jmtAHMcuPZo3Hzv9daSvc.9d9PWJNrth7bn0ZgIrjadhiLp4n2Ey2', 'sara@example.com'),
    ('Alice Wilson', '$2y$10$TwzdwkzdS5jfDWvKqM5vZO8R3kSYQRYAQEjRLtUg5cqhHSHpv4FV2', 'alice@example.com'),
    ('Charlie Miller', '$2y$10$.YGgLfpgYtNH8fISc0oXJORK9ZZ78v92Fv2T/pLSMCGtABmt0ULBi', 'charlie@example.com'),
    ('Dave Anderson', '$2y$10$emHhkPmHByVE2nczk7OWZOGHSWVd5l1jebFG6P9/f0Cjz0QkOP3ly', 'dave@example.com'),
    ('Emily Thomas', '$2y$10$QrL9/0LGDKfudDwnO4mQ8uylWUZyEkKJWik6bBHH6rwPqMqw9PxQ.', 'emily@example.com'),
    ('Frank Lee', '$2y$10$fsKhBexlihyG/KZ2/nhnu.wefGOXvAkqGwpZp5T.qLunaOrbWQ1GS', 'frank@example.com'),
    ('Grace Davis', '$2y$10$e0Ln6iwvREMlOn9n4SQ2XO4PwcSmW6fIVdgVT2i.JzrETZUx.OZY.', 'grace@example.com'),
    ('Oliver Clark', '$2y$10$L9PobSKCXKXMjlmC7FAYqufG8cf1i6t3A35Vpn5hOdJxtXxmMtAoS', 'oliver@example.com'),
    ('Sophia Walker', '$2y$10$yMxfKLh2gPyZSSUZWbrAAO0ZORdJuent2srKYXkL6fZB9r3qnbu/G', 'sophia@example.com'),
    ('Henry Turner', '$2y$10$Vtan5l/tnkp51JlZBDlHYeHk40e8yjjUqIrvcU5CBg1nWQDSLa83i', 'henry@example.com'),
    ('Lily Moore', '$2y$10$Ot5ubVWSW64x.aeu1ZZ46e7hrcG7sSxbwsc6JCbcoJjGjMMKVBjpS', 'lily@example.com');

INSERT INTO DEPARTMENTS (department_name)
VALUES
    ('Sales'),
    ('Customer Support'),
    ('Billing'),
    ('Technical Support'),
    ('Marketing'),
    ('Product Development'),
    ('Human Resources');

INSERT INTO AGENTS (client_id, department_id)
VALUES
(1, null),
(2, 2),
(3, 3),
(8, 3),
(9, 4),
(10, 5),
(11, 6),
(12, 7);

INSERT INTO ADMINS (client_id, agent_id)
VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8);

INSERT INTO FAQS (department_id, question, answer) VALUES
(1, 'How can I place an order?', 'You can place an order through our website or by calling our sales team.'),
(1, 'Do you offer international shipping?', 'Yes, we offer international shipping to select countries.'),
(2, 'What are your customer service hours?', 'Our customer service team is available 24/7.'),
(2, 'How can I track my order?', 'You can track your order by logging into your account on our website.'),
(3, 'How do I update my billing information?', 'You can update your billing information in your account settings.'),
(3, 'How can I cancel my subscription?', 'To cancel your subscription, please contact our billing department.'),
(4, 'How do I troubleshoot an issue with my product?', 'Please consult the user manual that came with your product or visit our support website for more information.'),
(4, 'Can I schedule a technical support call?', 'Yes, you can schedule a call with our technical support team by filling out the support request form on our website.'),
(5, 'What forms of payment do you accept?', 'We accept credit cards, PayPal, and bank transfers.'),
(5, 'How can I sign up for your newsletter?', 'You can sign up for our newsletter on our website.'),
(6, 'How can I provide feedback or suggest a new feature?', 'You can provide feedback or suggest new features by filling out the feedback form on our website.'),
(6, 'Are you accepting beta testers for new products?', 'Yes, we occasionally accept beta testers for our new products. Please contact our product development department for more information.'),
(7, 'What is your company culture like?', 'Our company culture is focused on teamwork, innovation, and personal growth.'),
(7, 'Do you have any job openings?', 'We regularly post job openings on our careers page. Please visit our website for more information.');

INSERT INTO TICKETS (agent_id, client_id, department_id, status, title) VALUES
(null, 5, 1, 'Open', 'Issue with product delivery'),
(null, 6, 2, 'Open', 'Billing inquiry'),
(null, 7, 3, 'Not Assigned', 'Technical issue with software'),
(null, 6, 4, 'Not Assigned', 'Marketing campaign feedback'),
(null, 5, 5, 'Not Assigned', 'Billing dispute'),
(null, 9, 6, 'Open', 'Product feature suggestion'),
(null, 10, 7, 'Open', 'Job application inquiry'),
(null, 8, 2, 'Open', 'Request for refund'),
(null, 9, 3, 'Open', 'Software installation issue'),
(null, 10, 4, 'Not Assigned', 'Feedback on new product design'),
(null, 5, 5, 'Not Assigned', 'Account billing discrepancy'),
(null, 6, 6, 'Open', 'Inquiry about product availability');

INSERT INTO MESSAGES (ticket_id, message_content, client_id) VALUES
(1, 'My product has not arrived yet. When can I expect delivery?', 5),
(2, 'I received an incorrect charge on my bill. Can you help me resolve this?', 6),
(3, 'I am having trouble with the software crashing. What can I do to fix this?', 7),
(4, 'I did not find the marketing campaign engaging. Do you have any plans to change it?', 6),
(5, 'I was charged for services I did not receive. How can I dispute this?', 5),
(6, 'I have a suggestion for a new product feature. Can I share it with your team?', 9),
(7, 'I am interested in applying for a job at your company. Are there any open positions?', 10),
(8, 'I would like to request a refund for my recent purchase. The product did not meet my expectations.', 8),
(9, 'I am having trouble installing the software on my computer. It keeps giving me an error message.', 9),
(10, 'I have some feedback regarding the design of the new product. Is there a specific channel to provide input?', 10),
(11, 'There is a discrepancy in my account billing. I have been charged for services I did not use.', 5),
(12, 'I would like to know when the product will be back in stock. It has been out of stock for a while.', 6);


INSERT INTO HASHTAGS (hashtag_name) VALUES
('#buy'),
('#pay'),
('#delivery'),
('#billing'),
('#software'),
('#marketing'),
('#product'),
('#job');

-- Populating Ticket_Hashtags

INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES
(1, 1),
(1, 2),
(1, 3);

INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES
(2, 4),
(2, 5),
(2, 6);

INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES
(3, 5),
(3, 6);

INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES
(4, 6);

INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES
(5, 4),
(5, 6);

INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES
(6, 6),
(6, 7);

INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES
(7, 7),
(7, 8);


UPDATE TICKETS SET status = 'Not Assigned' WHERE agent_id IS NULL;

UPDATE TICKETS SET agent_id = NULL WHERE status IS 'Not Assigned'