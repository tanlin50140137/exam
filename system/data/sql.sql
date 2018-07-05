#考试系统
create database if not exists htx_exam default character set 'utf8';
#会员登录
drop table if exists htx_admin;
create table htx_admin(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	users   varchar(255) not null default '' comment '登录帐号',
	pwd     varchar(255) not null default '' comment '登录密码',
	tel     varchar(255) not null default '' comment '手机-注册',
	email   varchar(255) not null default '' comment '邮箱-注册',
	p_pay   varchar(255) not null default '' comment '当前支付金额',
	h_pay   varchar(255) not null default '' comment '历时金额',
	t_pay   varchar(255) not null default '' comment '当前可用金额',
	ky_date varchar(255) not null default '' comment '可用天数',
	pic     varchar(255) not null default '' comment '头像',
	pay_time  int(11) unsigned not null default 0 comment '续费时间',
	dqy_time  int(11) unsigned not null default 0 comment '到期时间',
	tzy_time  int(11) unsigned not null default 0 comment '通知时间',
	publitime int(11) unsigned not null default 0 comment '注册时间',
	state tinyint(10) unsigned not null default 0 comment '状态,0=正常,1=禁止',
	key key_users(users),
	key key_publitime(publitime),
	key key_state(state)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#头像包
drop table if exists htx_apack;
create table htx_apack(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	picapth varchar(255) not null default '' comment '头像地址',
	picname varchar(255) not null default '' comment '头像图片名称',
	picsize varchar(255) not null default '' comment '头像大小',
	key key_picname(picname)	
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
INSERT INTO htx_apack(picname) VALUES('default/533e4c700001c60f02200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/533e4c700001c60f02200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/533e4c1500010baf02200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/533e4d3d0001ed7802000200.jpg');
INSERT INTO htx_apack(picname) VALUES('default/533e4fc800012f3002000200.jpg');
INSERT INTO htx_apack(picname) VALUES('default/533e51840001ca2502000200.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5333a0aa000121d702000200.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5333a0f60001eaa802200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5333a2b70001a5a802000200.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5333a08f0001700202000200.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5333a0600001f9ed02000200.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5333a0780001a6e702200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/54584cb50001e5b302200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/54584d9f0001043b02200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/54584d080001566902200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/54584dad0001dd7802200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/54584ef20001deba02200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/54584f3100019e9702200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/545847d40001cbef02200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/545861d500015cc602200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/545861f00001be3402200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/545865da00012e6402200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5458625e000166a002190220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5458639d0001bed702200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5458676e0001af7702200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/5458689e000115c602200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/545846580001fede02200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/545850200001359c02200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/545864190001966102200220.jpg');
INSERT INTO htx_apack(picname) VALUES('default/545867340001101702200220.jpg');
#分类
drop table if exists htx_classify;
create table htx_classify(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment '添加父类',
	title varchar(255) not null default '' comment '分类名称',
	sort varchar(255) not null default '' comment '分类排序',
	descri varchar(255) not null default '' comment '分类描述',
	publitime int(11) unsigned not null default 0 comment '创间时间',
	state tinyint(10) unsigned not null default 0 comment '状态,0=显示,1=隐藏',
	key key_pid(pid),
	key key_title(title),
	key key_sort(sort)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';