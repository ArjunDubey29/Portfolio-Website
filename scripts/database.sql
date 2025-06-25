-- Create database
CREATE DATABASE IF NOT EXISTS portfolio_db;
USE portfolio_db;

-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    linkedin VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Education table
CREATE TABLE education (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    level ENUM('Matriculation', 'Intermediate', 'Bachelors', 'Masters', 'PhD') NOT NULL,
    institute VARCHAR(255) NOT NULL,
    board VARCHAR(255),
    year YEAR NOT NULL,
    score VARCHAR(10),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Projects table
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    language_used VARCHAR(255),
    libraries_used TEXT,
    model_used VARCHAR(255),
    description TEXT,
    project_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Skills table
CREATE TABLE skills (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    skill_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Certifications table
CREATE TABLE certifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    issuing_organization VARCHAR(255),
    issue_date DATE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Languages known table
CREATE TABLE languages_known (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    language VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Hobbies table
CREATE TABLE hobbies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    hobby VARCHAR(100) NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Messages table
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_name VARCHAR(100) NOT NULL,
    sender_email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    receiver_user_id INT NOT NULL,
    sent_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (receiver_user_id) REFERENCES users(id) ON DELETE CASCADE
);



-- Insert users
INSERT INTO users (name, email, password, phone, address, linkedin) VALUES
('Prince Dureja', 'princedureja00@gmail.com', SHA2('password123', 256), '+91 6377340076', '#117, NEW AMAN CITY, KHARAR, PUNJAB-140143', 'https://www.linkedin.com/in/prince-dureja-7a4240324/'),
('Arjun Dubey', 'arjundubey672@gmail.com', SHA2('password123', 256), '+91 8081995938', 'Sector 6/B, Vrindavan, Lucknow', 'https://www.linkedin.com/in/arjun-dubey-74bb9628a');

-- EDUCATION
INSERT INTO education (user_id, level, institute, board, year, score) VALUES
-- Prince
(1, 'Bachelors', 'Chandigarh University', NULL, 2027, '8.00 CGPA'),
(1, 'Intermediate', 'Don Bosco Public School, Sikri, Bharatpur', 'RBSE', 2020, '83.83%'),
(1, 'Matriculation', 'Little Flower School, Ramgarh, Alwar', 'RBSE', 2015, '85.83%'),

-- Arjun
(2, 'Bachelors', 'Chandigarh University', NULL, 2024, '7.12 CGPA'),
(2, 'Intermediate', 'Bal Vidya Mandir, Lucknow', 'CBSE', 2021, '72%'),
(2, 'Matriculation', 'Bal Vidya Mandir, Lucknow', 'CBSE', 2019, '72.33%');

-- PROJECTS
INSERT INTO projects (user_id, title, language_used, libraries_used, model_used, description, project_date) VALUES
-- Prince
(1, 'Prediction of productivity of an employee in coffee shop', 'Python', 'Sklearn, Keras, Numpy, Pandas', 'Keras', NULL, '2024-04-01'),
(1, 'Drowsiness Detection using Keras', 'Python', 'NumPy, Pandas, OpenCV, Matplotlib, TensorFlow, Keras, Dlib, Math, Time, Imutils, SciPy', 'CNN, Keras', NULL, '2024-02-01'),

-- Arjun
(2, 'Prediction of productivity', 'Python', 'Sklearn, Keras, Numpy, Pandas', 'Keras', NULL, '2024-04-01'),
(2, 'Drowsiness Detection using Keras', 'Python', 'NumPy, Pandas, OpenCV, Matplotlib, TensorFlow, Keras, Dlib, Math, Time, Imutils, SciPy', 'CNN, Keras', NULL, '2024-02-01'),
(2, 'Titanic Survival Prediction', 'Python', 'NumPy, Pandas, Seaborn, Matplotlib', 'Multiple classifiers', 'Logistic Regression, Random Forest, KNN, SVM, Decision Tree, Naive Bayes', '2023-11-01');

-- SKILLS
INSERT INTO skills (user_id, skill_name) VALUES
-- Prince
(1, 'C++'),
(1, 'HTML'),
(1, 'CSS'),
(1, 'Python'),
(1, 'JavaScript'),

-- Arjun
(2, 'C'),
(2, 'C++'),
(2, 'Python'),
(2, 'DSA');

-- CERTIFICATIONS
INSERT INTO certifications (user_id, name, issuing_organization, issue_date) VALUES
-- Prince
(1, 'Introduction to Ethereum Blockchain', 'Infosys', '2024-07-01'),
(1, 'Data Science in Python', 'Infosys', '2024-11-01'),
(1, 'Basics of Python', 'Infosys Springboard', '2023-08-01'),

-- Arjun
(2, 'Critical Thinking', NULL, NULL),
(2, 'Creative Thinking', NULL, NULL);

-- LANGUAGES KNOWN
INSERT INTO languages_known (user_id, language) VALUES
-- Prince
(1, 'English'),
(1, 'Hindi'),
(1, 'Punjabi'),

-- Arjun
(2, 'English'),
(2, 'Hindi');

-- HOBBIES
INSERT INTO hobbies (user_id, hobby) VALUES
-- Prince
(1, 'Cricket'),
(1, 'Travelling'),
(1, 'Coding'),
(1, 'Gardening'),

-- Arjun
(2, 'Music'),
(2, 'Coding'),
(2, 'Reading'),
(2, 'Traveling');


-- Insert user Ayush Sinha
INSERT INTO users (name, email, password, phone, address, linkedin) VALUES
('Ayush Sinha', 'ayushsinha267@gmail.com', SHA2('password123', 256), '+918271765332', NULL, 'http://www.linkedin.com/in/ayushsinha-cypts');

-- Get Ayush's user ID (assuming it's 3, otherwise use LAST_INSERT_ID() in live DB)
-- Here we assume id = 3
-- EDUCATION
INSERT INTO education (user_id, level, institute, board, year, score) VALUES
(3, 'Bachelors', 'Chandigarh University', NULL, 2027, NULL),
(3, 'Intermediate', 'Gyan Bharti Senior Secondary School, Gaya', NULL, 2023, NULL),
(3, 'Matriculation', 'Nazareth Academy, Gaya', NULL, 2021, NULL);

-- PROJECTS (Major + Minor)
INSERT INTO projects (user_id, title, language_used, libraries_used, model_used, description, project_date) VALUES
(3, 'Blogging Website', 'JavaScript, Node.js, Express.js', 'EJS', NULL, 'A blog platform where users can post/read blogs. Backend with Node/Express and frontend styled with JS/CSS.', '2024-02-01'),
(3, 'Drowsiness Detection Using Keras and OpenCV', 'Python', 'Keras, OpenCV', 'CNN', 'Real-time drowsiness detection using facial landmarks and eye aspect ratio.', '2024-01-15'),
(3, 'Facial Emotion Recognition Using CNN', 'Python', 'Keras, OpenCV', 'CNN', 'Emotion classification system from facial images using CNN.', '2023-12-01'),
(3, 'Rock, Paper, Scissors Game', 'HTML, CSS, JavaScript', NULL, NULL, 'A simple interactive game.', '2023-06-01'),
(3, 'Calculator', 'HTML, CSS, JavaScript', NULL, NULL, 'Basic calculator web app.', '2023-05-01'),
(3, 'To-Do List', 'HTML, CSS, JavaScript', NULL, NULL, 'Task management web app.', '2023-04-01'),
(3, 'YouTube Static Clone', 'HTML, CSS', NULL, NULL, 'A static replica of YouTube.', '2023-03-01'),
(3, 'Amazon Web Page with Checkout', 'HTML, CSS, JavaScript', NULL, NULL, 'E-commerce clone with cart & checkout.', '2023-02-01');

-- SKILLS
INSERT INTO skills (user_id, skill_name) VALUES
(3, 'C'),
(3, 'C++'),
(3, 'JavaScript'),
(3, 'HTML'),
(3, 'CSS'),
(3, 'Node.js'),
(3, 'Express.js'),
(3, 'DSA'),
(3, 'DBMS');

-- CERTIFICATIONS
-- No specific certifications listed; skip for now or add manually if desired.

-- LANGUAGES KNOWN
-- Not mentioned explicitly; skip or add manually if known.

-- HOBBIES
INSERT INTO hobbies (user_id, hobby) VALUES
(3, 'Coding'),
(3, 'Photography'),
(3, 'Gym'),
(3, 'Boxing');
