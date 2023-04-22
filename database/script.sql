PRAGMA foreign_keys = ON;

DROP TABLE IF EXISTS HASHTAGS;
DROP TABLE IF EXISTS MESSAGES;
DROP TABLE IF EXISTS TICKETS;
DROP TABLE IF EXISTS FAQS;
DROP TABLE IF EXISTS ADMINS;
DROP TABLE IF EXISTS AGENTS;
DROP TABLE IF EXISTS CLIENTS;
DROP TABLE IF EXISTS DEPARTMENTS;

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
    hashtag_id INTEGER,
    FOREIGN KEY(department_id) REFERENCES DEPARTMENTS(department_id),
    FOREIGN KEY(client_id) REFERENCES CLIENTS(client_id),
    FOREIGN KEY(agent_id) REFERENCES AGENTS(agent_id),
    FOREIGN KEY(hashtag_id) REFERENCES HASHTAGS(hashtag_id)
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

-- Inserting admin account into the database
INSERT INTO CLIENTS (username, password, email)
VALUES ('admin', 'admin', 'admin@gmail.com');

INSERT INTO AGENTS (client_id)
VALUES (1);

INSERT INTO ADMINS (client_id, agent_id)
VALUES (1, 1);

--Inserting data into the database
INSERT INTO CLIENTS (username, password, email)
VALUES ('client1', 'client1', 'client1@gmail.com');
