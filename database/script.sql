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
    ('John', 'john', 'john@example.com'),
    ('Jane', 'jane', 'jane@example.com'),
    ('Bob', 'bob', 'bob@example.com'),
    ('Sara', 'sara', 'sara@example.com'),
    ('Alice', 'alice', 'alice@example.com'),
    ('Charlie', 'charlie', 'charlie@example.com'),
    ('Dave', 'dave', 'dave@example.com'),
    ('Emily', 'emily', 'emily@example.com'),
    ('Frank', 'frank', 'frank@example.com'),
    ('Grace', 'grace', 'grace@example.com');

INSERT INTO DEPARTMENTS (department_name)
VALUES
    ('Sales'),
    ('Customer Support'),
    ('Billing'),
    ('Technical Support'),
    ('Marketing');

INSERT INTO AGENTS (client_id, department_id)
VALUES
    (1,null),
    (2, 2),
    (3, 3),
    (4, 4),
    (5, 2),
    (6, 4),
    (7, 1),
    (8, 3),
    (9, 4),
    (10, 5);

INSERT INTO ADMINS (client_id, agent_id)
VALUES
    (1, 1);

INSERT INTO FAQS (department_id, question, answer) VALUES 
(1, 'How can I place an order?', 'You can place an order through our website or by calling our sales team.'),
(2, 'What are your customer service hours?', 'Our customer service team is available 24/7.'),
(3, 'How do I troubleshoot an issue with my product?', 'Please consult the user manual that came with your product or visit our support website for more information.'),
(4, 'How can I sign up for your newsletter?', 'You can sign up for our newsletter on our website.'),
(5, 'What forms of payment do you accept?', 'We accept credit cards, PayPal, and bank transfers.');

INSERT INTO TICKETS (agent_id, client_id, department_id, status, title) VALUES 
(NULL, 1, 1, 'Open', 'Issue with product delivery'),
(NULL, 2, 2, 'Open', 'Billing inquiry'),
(NULL, 3, 3, 'Not Assigned', 'Technical issue with software'),
(NULL, 4, 4, 'Not Assigned', 'Marketing campaign feedback'),
(NULL, 5, 5, 'Not Assigned', 'Billing dispute');

INSERT INTO MESSAGES (ticket_id, message_content, client_id) VALUES 
(1, 'My product has not arrived yet. When can I expect delivery?', 1),
(2, 'I received an incorrect charge on my bill. Can you help me resolve this?', 2),
(3, 'I am having trouble with the software crashing. What can I do to fix this?', 3),
(4, 'I did not find the marketing campaign engaging. Do you have any plans to change it?', 4),
(5, 'I was charged for services I did not receive. How can I dispute this?', 5);

-- Populating Hashtags
INSERT INTO HASHTAGS (hashtag_name)
VALUES ('#buy');
INSERT INTO HASHTAGS (hashtag_name)
VALUES ('#pay');

-- Populating Ticket_Hashtags
INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id)
VALUES (1, 1);
INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id)
VALUES (1, 2);



UPDATE tickets
SET status = 'Not Assigned'
WHERE agent_id IS NULL;

UPDATE tickets
SET agent_id = NULL
WHERE status IS 'Not Assigned';