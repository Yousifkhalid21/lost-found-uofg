-- استورد هذا الملف من phpMyAdmin داخل قاعدة البيانات التي أنشأتها في InfinityFree

-- الكليات (قائمة مغلقة يختار منها المستخدم عند التسجيل)
CREATE TABLE faculties (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  slug VARCHAR(30) NOT NULL UNIQUE   -- اسم ملف الشعار في assets/faculties/
) CHARACTER SET utf8mb4;

INSERT INTO faculties (name, slug) VALUES
('كلية الطب', 'medicine'),
('كلية العلوم الرياضية والحاسوب', 'mathcs'),
('كلية الصيدلة', 'pharmacy');

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  faculty_id INT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (faculty_id) REFERENCES faculties(id)
) CHARACTER SET utf8mb4;

CREATE TABLE items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  faculty_id INT NULL,               -- الكلية التي فُقد/وُجد فيها الغرض
  title VARCHAR(150) NOT NULL,
  type ENUM('lost','found') NOT NULL,
  place VARCHAR(150) NOT NULL,
  description TEXT,
  contact VARCHAR(150) NOT NULL,
  image VARCHAR(100) DEFAULT NULL,
  status ENUM('open','returned') NOT NULL DEFAULT 'open',  -- returned = تم تسليمه لصاحبه
  returned_at TIMESTAMP NULL DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4;

CREATE TABLE messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4;
