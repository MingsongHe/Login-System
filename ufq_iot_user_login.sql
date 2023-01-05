
-- SQL数据库名
-- Database: `emscom_wp12356` //这是笔者已经有了的数据库，数据库名是 emscom_wp12356

-- --------------------------------------------------------

-- 建立一个数据表：  ufq_iot_user_login
-- Table structure for table `ufq_iot_user_login`
-- id 字段和 create_at 字段也可以不要

CREATE TABLE `ufq_iot_user_login` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `status` int(11) NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
COMMIT;


-- 指定数据表索引字段id
-- Indexes for table

ALTER TABLE `ufq_iot_user_login`
  ADD PRIMARY KEY (`id`);


-- 设置索引字段id为自动增值
-- AUTO_INCREMENT for table

ALTER TABLE `ufq_iot_user_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
