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

-- Inserting admin account into the database
INSERT INTO CLIENTS (username, password, email)
VALUES ('admin', 'admin', 'admin@gmail.com');

INSERT INTO AGENTS (client_id)
VALUES (1);

INSERT INTO ADMINS (client_id, agent_id)
VALUES (1, 1);

-- Populating database
-- Populating clients

INSERT INTO CLIENTS (username, password, email)
VALUES ('joao', 'joao', 'joao@gmail.com');

INSERT INTO CLIENTS (username, password, email)
VALUES ('diogo', 'diogo', 'diogo@gmail.com');

INSERT INTO CLIENTS (username, password, email)
VALUES ('pedro', 'pedro', 'pedro@gmail.com');

INSERT INTO CLIENTS (username, password, email)
VALUES ('joel', 'joel', 'joel@gmail.com');

INSERT INTO CLIENTS (username, password, email)
VALUES ('sara', 'sara', 'sara@gmail.com');

-- Populating Agents 

INSERT INTO AGENTS (client_id, department_id)
VALUES (2, 1);
INSERT INTO AGENTS (client_id, department_id)
VALUES (3, 2);
INSERT INTO AGENTS (client_id, department_id)

-- Populating Departments
INSERT INTO DEPARTMENTS (department_name)
VALUES ('Sales');
INSERT INTO DEPARTMENTS (department_name)
VALUES ('Support');

-- Populating FAQs
INSERT INTO FAQS (department_id, question, answer)
VALUES (1, 'How to buy?', 'You can buy by clicking on the buy button.');
INSERT INTO FAQS (department_id, question, answer)
VALUES (2, 'How to pay?', 'You can pay by clicking on the pay button.');

-- Populating Tickets
INSERT INTO TICKETS (agent_id, client_id, department_id, status,title)
VALUES (2, 4, 1, 1, 'How to buy?');

INSERT INTO TICKETS (agent_id, client_id, department_id, status, title)
VALUES (3, 5, 2, 1, 'How to pay?');

-- Populating Messages
INSERT INTO MESSAGES (ticket_id, message_content, client_id)
VALUES (1, 'I want to buy this product.', 4);
INSERT INTO MESSAGES (ticket_id, message_content, client_id)
VALUES (1, 'You need to click on the buy button.', 2);
INSERT INTO MESSAGES (ticket_id, message_content, client_id)
VALUES (1, 'I want to buy this product.', 5);
INSERT INTO MESSAGES (ticket_id, message_content, client_id)
VALUES (1, 'You need to click on the buy button.', 3);

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

