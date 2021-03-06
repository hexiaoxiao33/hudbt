<?php

$lang_tags = array
(
	'text_description' => "简介:",
	'text_syntax' => "语法:",
	'text_example' => "例子:",
	'text_result' => "结果:",
	'text_remarks' => "说明:",
	'head_tags' => "标签",
	'text_tags' => "标签",
	'text_bb_tags_note' => "<b>".$SITENAME."</b>论坛支持一些<i>BBCode标签代码</i>，你可以在帖子中使用它们改变显示效果。",
	'submit_test_this_code' => "测试标签！",
	'tags' => [['name' => '粗体',
		    'desc' => '',
		    'syntax' => '[b]<kbd>粗</kbd>[/b]',
		    'example' => '[b]粗[/b]',
		    ],
		   ['name' => '斜体',
		    'desc' => '',
		    'syntax' => '[i]<kbd>歪</kbd>[/i]',
		    'example' => '[i]歪[/i]',
		    ],
		   ['name' => '下划线',
		    'desc' => '',
		    'syntax' => '[u]<kbd>填空</kbd>[/u]',
		    'example' => '[u]填空[/u]',
		    ],
		   ['name' => '删除线',
		    'desc' => '',
		    'syntax' => '[s]<kbd>没说过</kbd>[/s]',
		    'example' => '[s]没说过[/s]',
		    ],
		   ['name' => '上标',
		    'desc' => '',
		    'syntax' => '[sup]<kbd>头</kbd>[/sup]',
		    'example' => 'E=mc[sup]2[/sup]',
		    ],
		   ['name' => '下标',
		    'desc' => '',
		    'syntax' => '[sub]<kbd>脚</kbd>[/sub]',
		    'example' => 'H[sub]2[/sub]SO[sub]4[/sub]',
		    ],
		   ['name' => '对齐',
		    'desc' => '',
		    'syntax' => '[align="<kbd>可选左中右</kbd>"]<kbd>D中央</kbd>[/align]',
		    'example' => '[align="center"]D中央[/align]',
		    ],
		   ['name' => '一级标题',
		    'desc' => '',
		    'syntax' => '[h1]<kbd>一哥专用标题</kbd>[/h1]',
		    'example' => '[h1]一哥专用标题[/h1]',
		    ],
		   ['name' => '二级标题',
		    'desc' => '',
		    'syntax' => '[h2]<kbd>总理级标题</kbd>[/h2]',
		    'example' => '[h2]总理级标题[/h2]',
		    ],
		   ['name' => '三级标题',
		    'desc' => '',
		    'syntax' => '[h3]<kbd>省部级标题</kbd>[/h3]',
		    'example' => '[h3]省部级标题[/h3]',
		    ],
		   ['name' => '四级标题',
		    'desc' => '',
		    'syntax' => '[h4]<kbd>司厅级标题</kbd>[/h4]',
		    'example' => '[h4]司厅级标题[/h4]',
		    ],
		   ['name' => '五级标题',
		    'desc' => '',
		    'syntax' => '[h5]<kbd>县处级标题</kbd>[/h5]',
		    'example' => '[h5]县处级标题[/h5]',
		    ],
		   ['name' => '六级标题',
		    'desc' => '',
		    'syntax' => '[h6]<kbd>科长级标题</kbd>[/h6]',
		    'example' => '[h6]科长级标题[/h6]',
		    ],
		   ['name' => '颜色',
		    'desc' => '<var>color</var>属性可以使用类似<code>blue, yellow</code>，也可以使用CSS代码，例如<code>#00ff00</code>，甚至<code>RGBA</code>函数，详见<a href="http://www.w3.org/TR/css3-color/">W3C</a>',
		    'syntax' => '[color="red"]<kbd>我红了</kbd>[/color]',
		    'example' => '[color="red"]我红了[/color]',
		    ],
		   ['name' => '字体大小',
		    'desc' => '必须是在1(最小)到7(最大)间的整数。默认字号为2',
		    'syntax' => '[size="4"]<kbd>大</kbd>[/size]',
		    'example' => '[size=4]大[/size]',
		    ],
		   ['name' => '字体',
		    'desc' => '字体名的写法其实挺复杂的，具体参见CSS语法',
		    'syntax' => '[font="STXihei, STHeiti, \'Microsoft YaHei\'"]<kbd>黑</kbd>[/font]',
		    'example' => '[font="STXihei, STHeiti, \'Microsoft YaHei\'"]黑[/font]',
		    ],
		   ['name' => 'URL',
		    'desc' => '',
		    'syntax' => '[url="<kbd>URL</kbd>"]<kbd>文字</kbd>[/url]',
		    'example' => '[url=http://google.com]Google[/url]',
		    ],
		   ['name' => '图片',
		    'desc' => '宽/高单位为px，可以省略，一般指定其一即可；不要忘了自结束标记<code>/</code>',
		    'syntax' => '[img="<kbd>图片地址</kbd>" w="<kbd>宽度</kbd>" h="<kbd>高度</kbd>" /]',
		    'example' => '[img="/pic/logo.png" h="90" /]',
		    ],
		   ['name' => '引用',
		    'desc' => '来源可以省略',
		    'syntax' => '[quote="<kbd>来源</kbd>"]<kbd>啊? 你说什么?</kbd>[/quote]',
		    'example' => '[quote=\'[name=HUDBT]\']啊? 你说什么?[/quote]',
		    ],
		   ['name' => '代码',
		    'desc' => '此为行内元素，块元素请出门左转找<code>pre</code>',
		    'syntax' => '[code]<kbd style="font-family:menlo, monaco, courier, monospace">hello world</kbd>[/code]',
		    'example' => '[code]hello world[/code]',
		    ],
		   ['name' => '预定义文本',
		    'desc' => '内部会用等宽字体显示',
		    'syntax' => "[pre]<kbd>没有\n  格式\n 也不会自动换行哟</kbd>[/pre]",
		    'example' => "[pre]没有\n  格式\n 也不会自动换行哟[/pre]",
		    ],
		   ['name' => '分割线',
		    'desc' => '',
		    'syntax' => '[hr /]',
		    'example' => '[hr /]',
		    ],
		   ['name' => 'Flash',
		    'desc' => '',
		    'syntax' => '[flash w=320 h=240]<kbd>FLASH地址</kbd>[/flash]',
		    'example' =>  '[flash w=320 h=240]http://player.youku.com/player.php/sid/XNDEzMjk1NTky/v.swf[/flash]',
		    ],
		   ['name' => 'Span',
		    'desc' => '这就是给你玩CSS的...但是一切让文字超出外框的企图都会失败',
		    'syntax' => '[span style="<kbd>行内CSS</kbd>"]<kbd>咦</kbd>[/span]',
		    'example' => '[span style="display:block;background-color:purple;padding:10px;border:dashed silver 1px;border-radius:3px;box-shadow: 2px 2px 5px gray;width:100px;overflow-x:hidden;text-overflow:ellipsis;white-space:nowrap;margin:2em auto;"]it\'s css with looooooooooooooooooooooooooooooooooooooooooong contents[/span]',
		    ],
		   ['name' => '引用用户',
		    'desc' => '',
		    'syntax' => '[user=<kbd>用户ID</kbd>]',
		    'example' => '[user=1]',
		    ],
		   ['name' => '引用用户名',
		    'desc' => '',
		    'syntax' => '[name=<kbd>用户名</kbd>]',
		    'example' => '[name=HUDBT]',
		    ],
		   ['name' => '引用种子',
		    'desc' => '',
		    'syntax' => '[torrent=<kbd>种子ID</kbd>]',
		    'example' => '[torrent=2]',
		    ],
		   ['name' => '引用主题',
		    'desc' => '',
		    'syntax' => '[topic=<kbd>主题ID</kbd>]',
		    'example' => '[topic=13158]',
		    ],
		   ['name' => '引用帖子',
		    'desc' => '',
		    'syntax' => '[post=<kbd>帖子ID</kbd>]',
		    'example' => '[post=133916]',
		    ],
		   ['name' => '有序列表',
		    'desc' => '等同于HTML的&lt;ol>；内部项和无序列表可以混用, 项目符号样式详见<a href="http://www.w3school.com.cn/css/pr_list-style-type.asp">W3School</a>',
		    'syntax' => '[ol="<kbd>项目符号样式</kbd>"][li]<kbd>第一项</kbd>[/li][li]<kbd>第二项</kbd>[/li][/ol]',
		    'example' => '[ol="hiragana-iroha"][li]第一项[/li][li]第二项[/li][/ol]',
		    ],
		   ['name' => '无序列表',
		    'desc' => '等同于HTML的&lt;ul>，项目符号样式详见<a href="http://www.w3school.com.cn/css/pr_list-style-type.asp">W3School</a>',
		    'syntax' => "[ul=\"<kbd>项目符号样式</kbd>\"][*]<kbd>一项</kbd>\n[*]<kbd>又一项</kbd>\n[/ul]",
		    'example' => "<pre>[ul=\"square\"][*]一项\n[*]又一项\n[/ul]</pre>",
		    ],
		   ['name' => '定义列表',
		    'desc' => '等同于HTML的&lt;dl>',
		    'syntax' => "<pre>[dl][dt]<kbd>定义</kbd>[/dt]\n[dd]<kbd>含义</kbd>[/dd][/dl]</pre>",
		    'example' => "[dl][dt]美国总统[/dt][dd]美国的总统[/dd][/dl]",
		    ],		   
		   
		   ],


);


