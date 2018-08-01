create table tbl_disease
(
id int(10) primary key not null auto_increment,
age double not null default 0.0,
sex double not null default 0.0,
cp double not null default 0.0,
trestbps double not null default 0.0,
chol double not null default 0.0,
fbs double not null default 0.0,
restecg double not null default 0.0,
thalach double not null default 0.0,
exang double not null default 0.0,
oldpeak double not null default 0.0,
slop double not null default 0.0,
ca double not null default 0.0,
thal double not null default 0.0,
status double not null default 0.0
) engine=InnoDB default charset=utf8 comment '心脏病数据表';
