create table heart_disease (
id int(10) unsigned not null auto_increment commit 'id',
age varchar(10) not null default 0,
sex varchar(10) not null default 0,
cp varchar(10) not null default 0,
trestbps varchar(10) not null default 0,
chol varchar(10),
fbs varchar(10),
restecg varchar(10),
thalach varchar(10),
exang varchar(10),
oldpeak varchar(10),
slop varchar(10),
ca varchar(10),
thal varchar(10),
status varchar(10),
primary key ('id')
) engine=InnoDB default charset=utf8 commit '心脏病数据表';