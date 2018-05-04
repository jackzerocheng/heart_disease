create table tbl_disease ( id int(10) primary key not null auto_increment, age varchar(10) not null default '', sex varchar(10) not null default '', cp varchar(10) not null default '', trestbps varchar(10) not null default '', chol varchar(10), fbs varchar(10), restecg varchar(10), thalach varchar(10), exang varchar(10), oldpeak varchar(10), slop varchar(10), ca varchar(10), thal varchar(10), status varchar(10) ) engine=InnoDB default charset=utf8 comment '心脏病数据表';