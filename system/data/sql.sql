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
	pic     MediumText not null comment '头像',
	pay_time  int(11) unsigned not null default 0 comment '续费时间',
	dqy_time  int(11) unsigned not null default 0 comment '到期时间',
	tzy_time  int(11) unsigned not null default 0 comment '通知时间',
	publitime int(11) unsigned not null default 0 comment '注册时间',
	power tinyint(10) unsigned not null default 0 comment '权限,0=普通管理员,1=网站编辑员,2=超级管理员',
	state tinyint(10) unsigned not null default 0 comment '状态,0=正常,1=禁止',
	key key_users(users),
	key key_publitime(publitime),
	key key_state(state)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#添加后台会员权限
alter table htx_admin add power tinyint(10) unsigned not null default 0 comment '权限,0=普通管理员,1=网站编辑员,2=超级管理员' AFTER publitime;
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
drop table if exists htx_apack;
create table htx_apack(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	picapth varchar(255) not null default '' comment '头像地址',
	picname MediumText not null comment '头像图片名称',
	picsize varchar(255) not null default '' comment '头像大小'
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#考题分类
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
#创建文档分类
drop table if exists htx_fileclass;
create table htx_fileclass(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment '文档父类',
	title varchar(255) not null default '' comment '文档分类名称',
	sort varchar(255) not null default '' comment '文档分类排序',
	descri varchar(255) not null default '' comment '文档分类描述',
	publitime int(11) unsigned not null default 0 comment '文档创间时间',
	state tinyint(10) unsigned not null default 0 comment '状态,0=显示,1=隐藏',
	key key_pid(pid),
	key key_title(title),
	key key_sort(sort)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#创建文档
drop table if exists htx_createdts;
create table htx_createdts(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment '文档分类',
	title varchar(255) not null default '' comment '正标题',
	titleas varchar(255) not null default '' comment '副标题',			
	depict text not null comment '描述',	
	content MediumText not null comment '内容,大文本',
	tags varchar(255) not null default '' comment '标签',
	covers varchar(255) not null default '' comment '封面',
	static_n varchar(255) not null default '' comment '静态名称',
	publitime int(11) unsigned not null default 0 comment '文档创间时间',
	timing varchar(255) not null default '' comment '定时发布',
	state tinyint(10) unsigned not null default 0 comment '状态,0=发布,1=草稿箱',
	key key_pid(pid),
	key key_title(title),
	key key_publitime(publitime),
	key key_tags(tags),
	key key_state(state)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#发布公告
drop table if exists htx_notice;
create table htx_notice(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	centreno varchar(255) not null default '' comment '考场编号',
	title varchar(255) not null default '' comment '正标题',	
	content MediumText not null comment '内容,大文本',
	static_n varchar(255) not null default '' comment '静态名称',
	publitime int(11) unsigned not null default 0 comment '公告时间',
	state tinyint(10) unsigned not null default 0 comment '状态,0=发布,1=草稿箱',
	key key_centreno(centreno),
	key key_title(title),
	key key_publitime(publitime),
	key key_state(state)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#创建考场
drop table if exists htx_createroom;
create table htx_createroom(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment '关联分类ID',
	reluser varchar(255) not null default '' comment '关联用户ID',
	title varchar(255) not null default '' comment '考场名称',
	centreno varchar(255) not null default '' comment '考场编号',
	solve tinyint(10) unsigned not null default 0 comment '揽题方式,0=只揽所选分类,1=包括所有子分类',
	sort varchar(255) not null default '' comment '考场排序',
	tariff tinyint(10) unsigned not null default 0 comment '资费模式,0=免费,1=收费',
	descri MediumText not null comment '考场描述',
	roomsets tinyint(10) unsigned not null default 0 comment '设置考场,0=练习,1=正式考',
	typeofs tinyint(10) unsigned not null default 0 comment '题型,0=单选题,1=多选题,2=判断题,3=问答题',
	rule1 text not null comment '规则1',	
	rule2 text not null comment '规则2',	
	publitime int(11) unsigned not null default 0 comment '考场创间时间',
	counts int(10) unsigned not null default 0 comment '统计数、点击量、浏览量',
	state tinyint(10) unsigned not null default 0 comment '状态,0=显示,1=隐藏',
	key key_pid(pid),
	key key_reluser(reluser),
	key key_title(title),
	key key_sort(sort)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';
#导入题库
drop table if exists htx_examination;
create table htx_examination(
	id int(10) unsigned not null auto_increment primary key comment '主键',
	pid int(10) unsigned not null default 0 comment '关联分类ID - 与题种分类',
	typeofs tinyint(10) unsigned not null default 0 comment '题型,1=单选题,2=多选题,3=判断题,4=问答题',
	dry varchar(255) not null default '' comment '题干',
	options varchar(255) not null default '' comment '选项',
	numbers varchar(255) not null default '' comment '选项数',
	answers varchar(255) not null default '' comment '答案',
	analysis text not null comment '解析',	
	years varchar(255) not null default '' comment '考题年份',
	booknames varchar(255) not null default '' comment '书本名称',
	subtitles varchar(255) not null default '' comment '书本小标题',
	chapters varchar(255) not null default '' comment '章节',
	hats varchar(255) not null default '' comment '帽题',	
	publitime int(11) unsigned not null default 0 comment '导入时间',
	state tinyint(10) unsigned not null default 0 comment '状态,0=显示,1=隐藏',
	key key_pid(pid),
	key key_dry(dry),
	key key_options(options),
	key key_years(years),
	key key_booknames(booknames),
	key key_subtitles(subtitles),
	key key_typeofs(typeofs)
)ENGINE=MyISAM DEFAULT CHARSET='utf8';