-- the sql queries used throughout the code:

SELECT babyID
FROM babies
WHERE userID = :user_id
LIMIT 1;

SELECT * 
FROM categories
ORDER BY categoryID;

SELECT a.*, b.babyName
FROM activities a
JOIN babies b ON a.babyID = b.babyID
WHERE a.userID = :user_id
AND a.babyID = :baby_id
AND a.categoryID = :category_id
ORDER BY a.activityID;

SELECT * FROM babies 
WHERE userID = :user_id 
ORDER BY babyName;

UPDATE activities
SET categoryID = :categoryID, babyID = :babyID, 
userID =:userID, time =:time, description =:description
WHERE activityID =:activityID;

SELECT * FROM activities
WHERE activityID = :activityID;

INSERT INTO activities (categoryID, babyID, userID, time, description)
VALUES (:categoryID, :babyID, :userID, :time, :description);

SELECT *
FROM categories
ORDER BY categoryID;

DELETE FROM activities
WHERE activityID = :activityID;

INSERT INTO users (username, passwordHash, fullName)
VALUES (:username, :passwordHash, :fullName);

SELECT * 
FROM users 
WHERE username = :username;

SELECT 
c.categoryName,
COUNT(*) AS total
FROM activities a
JOIN categories c ON a.categoryID = c.categoryID
WHERE a.babyID = :babyID
AND a.userID = :userID
AND a.time BETWEEN :start AND :end
GROUP BY c.categoryName
ORDER BY c.categoryName;

SELECT 
a.activityID,
c.categoryName,
a.description,
a.time
FROM activities a
JOIN categories c ON a.categoryID = c.categoryID
WHERE a.babyID = :babyID
AND a.userID = :userID
AND a.time BETWEEN :start AND :end
ORDER BY a.time;

SELECT * 
FROM doctor 
WHERE username = :username;

INSERT INTO doctor (username, passwordHash, fullName, type) 
VALUES (:username, :passwordHash, :fullName, :type);

