<?php
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */
define("IDOFS", "序号");
define("TYPEOFS", "题型");
define("DRYS", "提干");
define("OPTIONS", "选项");
define("NUMBERS", "选项数量");
define("ANSWERS", "答案");
define("ANALYSIS", "解析");
define("YEARS", "年份");
define("BOOKNAMES", "书本名称");
define("SUBTILES", "书本小标题");
define("CHAPTERS", "章节");
define("HATS", "题帽");
define("PILIANGXIUGAIBIAO", "批量修改表");
define("ONCHECKEDDATA", "没有查找到数据");
define("FILEGESHIERROR_1", "文件格式有误");
define("FILEGESHIERROR_2", "选择格式有误");
define("PERLISTFENLAI_1", "请选择分类");
define("PERLISTFENLAI_2", "题干不能留空");
define("PERLISTFENLAI_3", "选项不能留空");
define("PERLISTFENLAI_4", "数量不能留空");
define("PERLISTFENLAI_5", "答案不能留空");
define("PERLISTFENLAI_6", "请选择考场");
define("QUDATEONOK", "修改失败");
define("QUDATEYESOK", "修改成功");
define("DELETEYESOK", "删除成功");
define("DELETEONOK", "删除失败");
define("ADDONOK", "添加失败");
define("ADDYESOK", "添加成功");
define("SETYESOK", "注册成功");
define("SETONOK", "注册失败");
define("LOGINYESOK", "登录成功");
define("LOGINONOK", "登录失败");
define("USERISEXST_1", "*帐号已存在*");
define("USERISEXST_2", "*帐号未注册*");
define("FROMRESETSUS_1", "*请输入帐号*");
define("FROMRESETSUS_2", "*帐号已存在*");
define("FROMRESETSUS_3", "*请输入密码*");
define("FROMRESETSUS_4", "*请输入手机*");
define("FROMRESETSUS_5", "*手机号错误*");
define("FROMRESETSUS_6", "*请输入邮箱*");
define("FROMRESETSUS_7", "*邮箱不正确*");
define("PERLISTFENLAIS_1", "请输入分类名称");
define("PERLISTFENLAIS_2", "分类名称已存在");
define("PERLISTFENLAIS_3", "请输入分类排序");
define("PERLISTINPUTTILE_1", "请输入标题");
define("PERLISTINPUTTILE_2", "请选入内容");
define("PERLISTINPUTTILE_3", "封面格式不正确");
define("PERLISTINPUTTILE_4", "封面大小不能超出2M");
define("PERLISTINPUTTILE_5", "文档创建失败");
define("USERPRONAME_1", "普通管理员");
define("USERPRONAME_2", "网站编辑员");
define("USERPRONAME_3", "超级管理员");
define("MIANFEI_E_1", "免费");
define("MIANFEI_E_2", "收费");
define("MIANFEI_B_1", "练习");
define("MIANFEI_B_2", "正式考");
define("DANXUANTI_1", "单选题");
define("DANXUANTI_2", "多选题");
define("DANXUANTI_3", "判断题");
define("DANXUANTI_4", "问答题");
define("SHOWZH_CN_1", "显示");
define("SHOWZH_CN_2", "隐藏");
define("SHOWZH_CN_3", "发布");
define("SHOWZH_CN_4", "[草稿箱]");
define("ERRORTISHIZH_CN_1", "加载失败：主题首页不存在 或 未启用主题 !");
define("ERRORTISHIZH_CN_2", "网站已经关闭，无法访问");
define("ERRORTISHIZH_CN_3", "加载失败：模块不存在!");
define("QITATISHIZH_CN_1", "秒前");
define("QITATISHIZH_CN_1_1", "秒");
define("QITATISHIZH_CN_2", "分钟前");
define("QITATISHIZH_CN_2_2", "分");
define("QITATISHIZH_CN_3", "小时前");
define("QITATISHIZH_CN_3_1", "小时");
define("QITATISHIZH_CN_4", "天前");
define("QITATISHIZH_CN_5", "个月前");
define("QITATISHIZH_CN_6", "年前");
define("MODILEERRORZH_CN_1", "模板不正确 “此模板应为添加导入模板” 不可用");
define("MODILEERRORZH_CN_2", "模板不正确 “此模板应为修改导入模板” 不可用");
define("SHOWINFO_ON_1", "获取失败");
define("KCONETINFO_ON_1", "操作空内容");
define("HOME_PAGE_1", "首页");
define("YENS_PAGE_1", "元");
define("YENS_PAGE_2", "原价");
define("YENS_PAGE_4", "天");
define("YENS_PAGE_3", "现价");
define("CLOSES_PAGE_1", "关闭");
define("FAMODLES_PAGE_1", "收费模式");
define("SHUTIANYK_PAGE_1", "可用天数");
define("SHUTIANYK_PAGE_2", "没有启用任何规则 ");
define("SHUTIANYK_PAGE_3", "请选择 ");
define("SHOWCENTRENO_1", "考场编号");
define("SHOWCENTRENO_2", "练习");
define("SHOWCENTRENO_3", "正式");
define("SHOWCENTRENO_4", "共");
define("SHOWCENTRENO_5", "题");
define("SHOWCENTRENO_6", "请选择答案");
define("SHOWCENTRENO_7", "错误");
define("SHOWCENTRENO_8", "正确");
define("SHOWCENTRENO_9", "你选择");
define("SHOWCENTRENO_10", "答案正确");
define("SHOWCENTRENO_11", "正确答案是");
define("SHOWCENTRENO_12", "确定");
define("SHOWCENTRENO_13", "放弃");
define("SHOWCENTRENO_14", "下一题");
define("SHOWCENTRENO_15", "答案错误");
define("SHOWCENTRENO_16", "放弃");
define("SHOWCENTRENO_17", "练习完毕,点击查看分析");
define("SHOWINSTALLENABLE_1", "安装启用程序");
define("SHOWINSTALLENABLE_2", "文件或目录不存在");
define("SHOWCENTRENO_18", "数据库连接错误");
define("SHOWCENTRENO_19", "语法错误");
define("SHOWCENTRENO_20", "创建数据库失败");
define("SHOWCENTRENO_21", "未查找到任何题目，或者没有导入；或者设置扩大揽题方式");
define("SHOWCENTRENO_22", "火天信考试VIP套餐");
define("SHOWCENTRENO_23", "未登录用户无法购买");
define("SHOWCENTRENO_24", "未购买VIP或者已经到期");
define("SHOWCENTRENO_25", "订单号并且用户名不能为空");
define("SHOWCENTRENO_26", "没有查找到考场信息");
define("SHOWCENTRENO_27", "规则未使用");
/**
 * 
 * @author TanLin Tel:18677197764 Email:50140137@qq.com  V.0727
 * 
 * @abstract 自主开发框架，本框架已经实现代码低冗余、高性能、高可用性，逻辑强、高稳定。一次开发，稳定无问题，维护成本低。
 * 
 */