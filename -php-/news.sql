-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2019 年 05 月 20 日 15:54
-- 服务器版本: 5.5.53
-- PHP 版本: 5.4.45

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `news`
--

-- --------------------------------------------------------

--
-- 表的结构 `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8 NOT NULL,
  `password` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'jinbei', '123');

-- --------------------------------------------------------

--
-- 表的结构 `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `news_id` int(20) NOT NULL AUTO_INCREMENT,
  `news_title` varchar(50) COLLATE utf8_bin NOT NULL,
  `news_type` varchar(20) COLLATE utf8_bin NOT NULL,
  `news_content` text COLLATE utf8_bin,
  `news_date` date NOT NULL,
  `news_author` varchar(20) COLLATE utf8_bin DEFAULT NULL,
  `bin_data` longblob NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=24 ;

--
-- 转存表中的数据 `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_type`, `news_content`, `news_date`, `news_author`, `bin_data`) VALUES
(1, '一条新闻(国际新闻)', '1', '这是一条新闻的内容', '2019-05-20', '金贝', 0xe4b880e69da1e696b0e997bb2e6a7067),
(2, '这是第二条新闻（国内新闻）', '1', '这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻，这里面写满了新闻', '2019-05-20', '金贝', 0xe7acace4ba8ce69da12e6a7067),
(4, '这是管理员添加的国际新闻', '1', '芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴芭拉芭拉芭巴拉巴', '2019-05-20', '金贝', 0xe59bbde999852e6a7067),
(3, '中国机场刺激美国人神经 特朗普：我们成第三世界', '1', '5月13日，国航、南航、东航与厦航四架大型客机在大兴机场执行验证飞行。\r\n　　国航的波音747-800、南航的空客A380、东航的空客A350-900以及厦航的波音787-900，四款代表着中国航空公司所拥有的最大最新的机型齐聚大兴机场，共襄盛事。而其起降的机场——正在建造中的北京大兴国际机场，在竣工后也将成为中国乃至世界最大机场。', '2019-05-20', NULL, 0xe69cbae59cba2e6a7067),
(6, '青春来袭！新晋小花朱丽岚曝最新夏日写真 ', '1', '由朱丽岚担纲女主的电影《人鱼江湖》已于5月9日在腾讯视频独家上线,上线5天播放量突破3000万,成绩斐然。由她饰演的女主鱼姬因在影片中的精彩表现而得到了观众们的一致认可与好评。\r\n朱丽岚在接下来还将有《穿越人海拥抱你》、《水怪》、《降龙觉醒》等多部影视作品即将播出,她还将带给我们怎样的惊喜呢?让我们一起来期待吧。', '2019-05-20', '大众娱乐网', 0xe69cb1e4b8bde5b29a2e6a7067),
(7, '赵露思：像春日一样明媚', '1', '似乎所有爱美的女生都有关于“时尚”的梦想,赵露思的时尚梦就是从事自己曾经的专业方向——服装设计。“穿适合自己的、能够驾驭的东西,在适当的时候有些突破,就是时尚。”对时尚颇有心得的赵露思,对自己的妆容、发型也同样在意。拍摄中,她时常不经意间甩开飘扬长发,在场的工作人员纷纷赞叹她的好发质,精致的她不仅在着装打扮上有自己的要求,平日对头发的养护也没有少下功夫。灵动甜美的长发少女,一袭白裙、笑靥如花,在这个明媚的春天,散发了无限的浪漫与温柔。', '2019-05-20', '大众娱乐网', 0xe8b5b5e6809de99cb22e706e67),
(8, '马克龙公开反对“华为禁令”：不打算屈服于美国压力', '1', '美国总统特朗普又宣布进入“国家紧急状态”了!这一次不是为了动用军费修边界墙，也不是应对卡特里娜那样的飓风，而是为了阻止“外国对手”对美国通信系统造成的“国家安全威胁”。这个“外国对手”是谁？美国商务部随即给出了答案，称中国电信巨头华为公司的活动“违反美国国家安全与外交政策利益”，决定将华为及其子公司列入出口管制黑名单。动用“国家紧急状态”，来对付中国一个公司，华盛顿的反应不得不令人感慨“太过夸张”。16日，中国外交部发言人陆慷在例行记者会上强调，中方坚决反对任何国家根据自己的国内法对中国的实体实施单边制裁，也反对泛化国家安全概念，滥用出口管制措施，敦促美方停止错误做法。针对美国财长称将于近期来华磋商的消息，中国商务部新闻发言人高峰16日称，中方不掌握美方来华磋商的计划。他表示，美方单方面不断升级贸易摩擦，使中美经贸磋商严重受挫。', '2019-05-20', '环球时报', 0xe9a9ace5858be9be992e6a7067),
(9, '纽约市长宣布参加大选，特朗普飞机上录视频嘲讽：你还是回纽约吧', '1', '当地时间16日，美国纽约市长白思豪宣布参加2020总统大选。意料之中，来自特朗普和媒体的嘲讽一波接着一波来了。\r\n　　据美媒报道，当地时间16日，纽约市长白思豪发布视频，正式宣布参加2020年美国总统大选，成为第23位宣布参选的民主党人。其视频主题为“把劳动者放在第一位(working people first)”。 视频中，白思豪阐述了对绿色新政和心理健康等议题的关注。在视频中，白思豪还向现任总统特朗普发起挑战说：“特朗普必须被阻止”。\r\n　　被如此直接点名，特朗普当然不甘示弱。\r\n　　不久，特朗普便在推特上发布了一段录制于专机空军一号上的视频，回击白思豪。在视频中，特朗普略带讽刺意味“惊讶”地说：“真不敢相信，我听说纽约史上最差的市长，毫无疑问也是美国史上最差市长正在竞选总统。”', '2019-05-20', '环球时报', 0xe789b9e69c97e699ae2e706e67),
(10, '黑龙江省逊克县一铁矿发生透水事故 19人被困', '2', '[#黑龙江省逊克县一铁矿发生透水事故#19人被困]记者从黑龙江省黑河市逊克县相关部门了解到，17日3时左右，逊克翠宏山铁矿发生透水事故，43人下井，其中24人已升井，19人被困。目前，被困人员中13人已联络上，确定了具体位置，6人还在联络中。黑河市、逊克县相关负责人和相关救援部门已赶到现场，正在开展救援。', '2019-05-20', '新华视点', 0xe99381e79fbf2e6a7067),
(11, '火箭少女燃降武汉 携手康师傅冰红茶再度演绎年轻化多元营销', '1', '2019年5月11日,康师傅冰红茶携手大势女团火箭少女101,在武汉武钢体育中心召开了一场别开声面的粉丝见面会。“山支大哥”孟美岐、Winnie紫宁、Sunnee杨芸晴空降舞台大秀技艺,尽显康师傅冰红茶代言人的青春洋溢和爆表燃力,三人青春酷爽的形象以及燃点不断的互动,不仅引发尖叫连连,更带领全场粉丝一同沉浸于一场冰力十足的燃痛快体验之中。', '2019-05-20', '大众娱乐网 责任编辑： 萧鑫 ', 0xe781abe7aeade5b091e5a5b32e6a7067),
(12, '《邻座的怪同学》超前点映 最甜的520应该这样过', '1', '1905电影网讯 超甜青春爱情电影《邻座的怪同学》将于5月23日全国上映，并于5月20日开启全国38城超前点映，北京、上海、广州、深圳、杭州等城市的观众将提前感受甜蜜暴击。点映消息一经公布，网友纷纷表示在甜甜的日子看甜甜的电影是再美妙不过的事！片方今日曝光 “怪喜欢你”版终极预告片，清新动人地展现了男女主角从孤独相遇到相互温暖的过程。据悉，电影预售已开启。', '2019-05-20', '1905电影网', 0xe982bbe5baa7e79a84e680aae5908ce5ada62e6a7067),
(13, '用来测试是否能成功上传图片到数据库', '1', '用来测试是否能成功上传图片到数据库用来测试是否能成功上传图片到数据库用来测试是否能成功上传图片到数据库用来测试是否能成功上传图片到数据库用来测试是否能成功上传图片到数据库', '2019-05-20', '测试', 0x30312e6a7067),
(14, '2用来测试是否能成功上传图片到数据库', '1', '2用来测试是否能成功上传图片到数据库2用来测试是否能成功上传图片到数据库2用来测试是否能成功上传图片到数据库2用来测试是否能成功上传图片到数据库2用来测试是否能成功上传图片到数据库', '2019-05-20', '金贝', 0x362e6a7067),
(15, '3用来测试是否能成功上传图片到数据库', '2', '3用来测试是否能成功上传图片到数据库3用来测试是否能成功上传图片到数据库3用来测试是否能成功上传图片到数据库3用来测试是否能成功上传图片到数据库', '2019-05-20', '测试', 0x352e6a7067),
(16, '4用来测试是否能成功上传图片到数据库', '1', '4用来测试是否能成功上传图片到数据库4用来测试是否能成功上传图片到数据库4用来测试是否能成功上传图片到数据库4用来测试是否能成功上传图片到数据库4用来测试是否能成功上传图片到数据库4用来测试是否能成功上传图片到数据库', '2019-05-20', '测试', 0x382e6a7067),
(17, '这是用来测试图片是否能上传到upload文件夹', '1', '这是用来测试图片是否能上传到upload文件夹这是用来测试图片是否能上传到upload文件夹这是用来测试图片是否能上传到upload文件夹这是用来测试图片是否能上传到upload文件夹这是用来测试图片是否能上传到upload文件夹', '2019-05-20', '测试', 0x342e6a7067),
(18, '2这是用来测试图片是否能上传到upload文件夹', '3', '2这是用来测试图片是否能上传到upload文件夹2这是用来测试图片是否能上传到upload文件夹2这是用来测试图片是否能上传到upload文件夹2这是用来测试图片是否能上传到upload文件夹2这是用来测试图片是否能上传到upload文件夹2这是用来测试图片是否能上传到upload文件夹', '2019-05-18', '测试', 0x312e6a7067),
(20, '这是用来测试数据库中是否存储了上传的文件名', '1', '这是用来测试数据库中是否存储了上传的文件名这是用来测试数据库中是否存储了上传的文件名这是用来测试数据库中是否存储了上传的文件名这是用来测试数据库中是否存储了上传的文件名', '2019-05-20', '测试', 0x322e6a7067),
(21, '这是一只萌萌（测试上传的图片是否能正常显示）', '1', '这是一只萌萌（测试上传的图片是否能正常显示）这是一只萌萌（测试上传的图片是否能正常显示）这是一只萌萌（测试上传的图片是否能正常显示）这是一只萌萌（测试上传的图片是否能正常显示）', '2019-05-20', '测试', 0x313134322e6a7067),
(22, '2这是一只萌萌（测试上传的图片是否能正常显示）', '1', '2这是一只萌萌（测试上传的图片是否能正常显示）2这是一只萌萌（测试上传的图片是否能正常显示）2这是一只萌萌（测试上传的图片是否能正常显示）2这是一只萌萌（测试上传的图片是否能正常显示）2这是一只萌萌（测试上传的图片是否能正常显示）2这是一只萌萌（测试上传的图片是否能正常显示）2这是一只萌萌（测试上传的图片是否能正常显示）', '2019-05-20', '测试', 0x323330322e6a7067),
(23, '这是一只猫爪', '3', '这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪这是一只猫爪', '2019-05-20', '金贝', 0x323132312e6a7067);

-- --------------------------------------------------------

--
-- 表的结构 `newstype`
--

CREATE TABLE IF NOT EXISTS `newstype` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(50) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=5 ;

--
-- 转存表中的数据 `newstype`
--

INSERT INTO `newstype` (`type_id`, `type_name`) VALUES
(1, '国际新闻'),
(2, '国内新闻'),
(3, '娱乐新闻');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
