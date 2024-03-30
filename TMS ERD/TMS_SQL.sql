-- Database
USE task_management;

-- Drop statements for all tables
DROP TABLE IF EXISTS Comment;
DROP TABLE IF EXISTS Task;
DROP TABLE IF EXISTS Categories;
DROP TABLE IF EXISTS User;

-- User table
CREATE TABLE User (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    department VARCHAR(50),
    role VARCHAR(50),
    password VARCHAR(255) NOT NULL 
);

-- Categories table
CREATE TABLE Categories (
    category_id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL
);

-- Task table
CREATE TABLE Task (
    task_id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    priority VARCHAR(20),
    deadline DATE,
    status VARCHAR(20),
    category_id INT,
    user_id INT,
    FOREIGN KEY (category_id) REFERENCES Categories(category_id),
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

-- Comment table
CREATE TABLE Comment (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    task_id INT,
    user_id INT,
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (task_id) REFERENCES Task(task_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES User(user_id)
);

-- Inserting data into User table
INSERT INTO User (username, department, role, password)
VALUES
('Manjot', 'IT', 'Manager', '123'),
('Lashman', 'IT', 'Developer', '123'),
('Jagseer', 'IT', 'Administrator', '123'),
('Manpreet', 'IT', 'Tester', '123'),
('Amna', 'IT', 'Designer', '123'),
('Bhatti', 'IT', 'Support Specialist', '123'),
('Gurpreet', 'IT', 'System Analyst', '123'),
('Lovepreet', 'IT', 'Network Engineer', '123'),
('Gagandeep', 'IT', 'Database Administrator', '123'),
('Prince', 'IT', 'Security Analyst', '123');

-- Inserting data into Categories table
INSERT INTO Categories (category_name) VALUES
('Meeting'),
('Development'),
('Design'),
('Documentation'),
('Testing'),
('Research'),
('Maintenance'),
('Marketing');

-- Inserting data into Task table
INSERT INTO Task (title, description, priority, deadline, status, category_id, user_id) VALUES
('Update Database Schema', 'Modify database schema to accommodate new requirements', 'High', '2024-04-05', 'In Progress', 2, 1),
('Code Refactoring', 'Refactor existing codebase for better performance', 'Medium', '2024-04-20', 'Pending', 2, 2),
('Create UI Mockups', 'Design user interface mockups for new features', 'Low', '2024-04-15', 'New', 3, 3),
('Write Technical Documentation', 'Prepare technical documentation for system architecture', 'High', '2024-04-10', 'In Progress', 4, 1),
('Perform System Testing', 'Conduct comprehensive testing of system functionalities', 'Medium', '2024-04-25', 'New', 5, 2),
('Conduct Market Research', 'Analyze market trends and gather insights for product development', 'Low', '2024-04-18', 'Pending', 6, 3),
('Implement Bug Fixes', 'Address reported bugs and issues in the application', 'High', '2024-04-08', 'In Progress', 7, 1),
('Launch Marketing Campaign', 'Execute planned marketing campaign across multiple channels', 'Medium', '2024-04-30', 'New', 8, 2),
('Perform Regular Maintenance', 'Perform routine maintenance tasks to ensure system stability', 'Low', '2024-04-22', 'Pending', 1, 3),
('Optimize SEO Strategies', 'Optimize website content and keywords for better search engine ranking', 'High', '2024-04-12', 'In Progress', 2, 1);

-- Inserting data into Comment table
INSERT INTO Comment (task_id, user_id, comment, created_at) VALUES
(4, 1, 'Database schema updated successfully.', NOW()),
(5, 2, 'Refactoring in progress, addressing performance bottlenecks.', NOW()),
(6, 3, 'Mockups created for new features, awaiting review.', NOW()),
(7, 1, 'Technical documentation in progress, documenting system architecture changes.', NOW()),
(8, 2, 'System testing initiated, validating functionalities.', NOW()),
(9, 3, 'Market research findings compiled, ready for analysis.', NOW()),
(10, 1, 'Bug fixes underway, addressing reported issues.', NOW()),
(1, 2, 'Marketing campaign launched, monitoring performance metrics.', NOW()),
(2, 3, 'Regular maintenance tasks scheduled for implementation.', NOW()),
(3, 1, 'SEO optimization strategies being implemented.', NOW());

-- Statments to print tables' column with data

SELECT * FROM User;
SELECT * FROM Categories;
SELECT * FROM Task;
SELECT * FROM Comment;
