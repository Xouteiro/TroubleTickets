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
agent_id INTEGER NOT NULL,
client_id INTEGER NOT NULL,
department_id INTEGER NOT NULL,
status BOOLEAN NOT NULL,
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

-- Inserting admin account into the database
INSERT INTO CLIENTS (username, password, email)
VALUES ('admin', 'admin', 'admin@gmail.com');

INSERT INTO AGENTS (client_id)
VALUES (1);

INSERT INTO ADMINS (client_id, agent_id)
VALUES (1, 1);

-- Populating database
-- Populating the DEPARTMENTS table
INSERT INTO DEPARTMENTS (department_name) VALUES ('Sales');
INSERT INTO DEPARTMENTS (department_name) VALUES ('Customer Support');
INSERT INTO DEPARTMENTS (department_name) VALUES ('Technical Support');

-- Populating the CLIENTS table
INSERT INTO CLIENTS (username, password, email) VALUES ('johndoe', 'password123', 'johndoe@gmail.com');
INSERT INTO CLIENTS (username, password, email) VALUES ('janedoe', 'qwertyuiop', 'janedoe@gmail.com');

-- Populating the AGENTS table
INSERT INTO AGENTS (client_id, department_id) VALUES (2, 2);
INSERT INTO AGENTS (client_id, department_id) VALUES (3, 3);

-- Populating the ADMINS table
INSERT INTO ADMINS (client_id, agent_id) VALUES (2, 2);

-- Populating the FAQS table
INSERT INTO FAQS (department_id, question, answer) VALUES (1, 'How can I place an order?', 'You can place an order through our website or by contacting our sales team.');
INSERT INTO FAQS (department_id, question, answer) VALUES (2, 'How can I get technical support?', 'You can submit a support ticket through our website or by contacting our technical support team.');
INSERT INTO FAQS (department_id, question, answer) VALUES (3, 'What do I do if I forget my password?', 'You can reset your password by clicking the "Forgot Password" link on our website login page.');

-- Populating the TICKETS table
INSERT INTO TICKETS (agent_id, client_id, department_id, status) VALUES (1, 1, 1, true);
INSERT INTO TICKETS (agent_id, client_id, department_id, status) VALUES (2, 2, 2, false);

-- Populating the MESSAGES table
INSERT INTO MESSAGES (ticket_id, message_content, client_id) VALUES (1, 'I would like to place an order for 10 widgets.', 1);
INSERT INTO MESSAGES (ticket_id, message_content, client_id) VALUES (1, 'Sure, we can help you with that. What is your preferred payment method?', 2);
INSERT INTO MESSAGES (ticket_id, message_content, client_id) VALUES (2, 'I am having trouble with my software installation.', 2);
INSERT INTO MESSAGES (ticket_id, message_content, client_id) VALUES (2, 'We apologize for the inconvenience. Our technical support team will reach out to you shortly.', 2);

-- Populating the HASHTAGS table
INSERT INTO HASHTAGS (hashtag_name) VALUES ('#sales');
INSERT INTO HASHTAGS (hashtag_name) VALUES ('#customer_support');
INSERT INTO HASHTAGS (hashtag_name) VALUES ('#technical_support');

-- Populating the TICKET_HASHTAGS table
INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES (1, 1);
INSERT INTO TICKET_HASHTAGS (ticket_id, hashtag_id) VALUES (2, 3);
