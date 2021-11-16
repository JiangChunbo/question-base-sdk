## 题库 SDK
### 使用准备
申请注册一个 App
&nbsp;
### 使用入门
- 创建一个 Service，并传递 App 相关参数
```php
$service = new \Tq\Qbs\V1\Service($open_id, $open_secret, $open_key);
```

- 注册新用户
```php
$user_info = $service->register($user_uuid, $username, $password);
```

反复调用会更新 user_uuid 的 username, password

- 获取 token

```php
$access_token = $service->getToken($user_uuid, $password);
```

- 调用相关接口
```php
$stages = $service->fetchAllStages();
$subjects = $service->fetchAllSubjects($stage);
$grades = $service->fetchAllGrades($stage);
$books = $service->fetchBooks($subject_id, $grade_id);
```
&nbsp;
## 接口
### 获取 Book
代码示例：
```php
$books = $service->fetchBooks($subject_id, $grade_id);
```
返回值示例：
```json
[
  {
    "id": 188,
    "grade_id": 6,
    "subject_id": 1,
    "edition_id": 11,
    "term": 1,
    "title": "六年级上（2014年版）"
  },
  {
    "id": 189,
    "grade_id": 6,
    "subject_id": 1,
    "edition_id": 11,
    "term": 2,
    "title": "六年级下"
  }
]
```

&nbsp;
### <span id="fetchDirectories1">获取 Directory1</span>
代码示例：
```php
$directories = $service->fetchDirectories1($book_id);
```
返回值示例：
```json
[
  {
    "id": 878,
    "sid": 0,
    "title": "第一单元",
    "children": [
      {
        "id": 879,
        "sid": 878,
        "title": "1 春\/朱自清"
      },
      {
        "id": 880,
        "sid": 878,
        "title": "2 济南的冬天\/老舍"
      },
      {
        "id": 881,
        "sid": 878,
        "title": "3* 雨的四季\/刘湛秋"
      },
      {
        "id": 882,
        "sid": 878,
        "title": "4 古代诗歌四首",
        "children": [
          {
            "id": 883,
            "sid": 882,
            "title": "观沧海\/曹操"
          },
          {
            "id": 884,
            "sid": 882,
            "title": "闻王昌龄左迁龙标遥有此寄\/李白"
          },
          {
            "id": 885,
            "sid": 882,
            "title": "次北固山下\/王湾"
          },
          {
            "id": 886,
            "sid": 882,
            "title": "天净沙·秋思\/马致远"
          }
        ]
      },
      {
        "id": 887,
        "sid": 878,
        "title": "写作 热爱生活，热爱写作"
      }
    ]
  }
]
```

&nbsp;
### 获取 Directory2
代码示例：
```php
$directories = $service->fetchDirectories2($subject_id, $grade_id, $term);
```
返回值示例：同 [获取 Directory1](#fetchDirectories1)

&nbsp;
### 获取 Question1
代码示例：
```php
$options = new \Tq\Qbs\V1\QuestionQueryOptions(1, 5);
$options->fetchOptions(true);
$options->fetchAnalyse(true);
$options->fetchAnswers(true);
$options->fetchCategory(true);
$options->fetchDiscuss(true);
$options->fetchMethod(true);
$question = $service->fetchQuestions1(5665, 1, $options);
```
返回值示例：
```json
[
  {
    "id": 321,
    "content": "估计2<sup>8<\/sup>cm接近于（　　）",
    "options": [
      "七年级数学课本的厚度",
      "姚明的身高",
      "六层教学楼的高度",
      "长白山主峰的高度"
    ],
    "answers": [
      "1"
    ],
    "method": "解：∵2<sup>8<\/sup>cm=256cm．<br \/>∴2<sup>8<\/sup>cm接近于姚明的身高．<br \/>故选：B．",
    "analyse": "2<sup>8<\/sup>cm=256cm，数学课本的厚度远远小于这个数，姚明的身高为230cm左右，则比较接近；长白山主峰的高度和六层楼的高度都大于这个数．",
    "discuss": "本题考查了数学常识．此类问题要结合实际问题来解决，生活中的一些数学常识要了解．比如给出一个物体的高度要会选择它合适的单位长度等等．平时要注意多观察，留意身边的小知识．",
    "category": {
      "id": 1,
      "title": "选择题",
      "is_objective": true
    }
  },
  {
    "id": 322,
    "content": "英寸是电视机常用的规格之一，1英寸约为拇指上面一节的长，则7英寸长大约相当于（　　）",
    "options": [
      "课本的宽度",
      "粉笔的长度",
      "课桌的宽度",
      "黑板的高度"
    ],
    "answers": [
      "0"
    ],
    "method": "解：拇指上面一节的长约为3cm左右，<br \/>则7寸长约为21cm左右，相当于课本的宽度．<br \/>故选：A．",
    "analyse": "拇指上面一节的长约为3cm左右，7寸长=1寸长×7．",
    "discuss": "此题考查了数学常识，结合生活，联系实际是解题的关键．",
    "category": {
      "id": 1,
      "title": "选择题",
      "is_objective": true
    }
  },
  {
    "id": 323,
    "content": "<img alt=\"菁优网\" src=\"http:\/\/img.jyeoo.net\/quiz\/images\/202109\/84\/5a06e11f.png\" style=\"vertical-align:middle;FLOAT:right\" \/>刘徽是中国三国时期杰出的数学大师，他的一生是为数学刻苦探究的一生，在数学理论上的贡献与成就十分突出，被称为“中国数学史上的牛顿”，他在一本著作中编选了“海岛上高、深、广、远”等九个测量问题，这本著作是（　　）",
    "options": [
      "《九章算术》",
      "《周髀算经》",
      "《孙子算经》",
      "《海岛算经》"
    ],
    "answers": [
      "3"
    ],
    "method": "解：这本书是《海岛算经》，主要是有关测量的问题，<br \/>故选：D．",
    "analyse": "根据测量问题可以知道是《海岛算经》．",
    "discuss": "本题考查了数学常识，掌握课本上的读一读是解题的关键．",
    "category": {
      "id": 1,
      "title": "选择题",
      "is_objective": true
    }
  },
  {
    "id": 324,
    "content": "在“算经十书”中，《九章算术》是中国古代记载最全面完整的一部著作，它的出现标志中国古代数学形成了完整的体系，而《海岛算经》则是中国最早的一部测量数学专著，使“中国在数学测量学的成就，超越西方约一千年”，这两本著作是下列哪位数学家留给后世的宝贵数学遗产（　　）",
    "options": [
      "<img alt=\"菁优网\" src=\"http:\/\/img.jyeoo.net\/quiz\/images\/202109\/91\/f2a3dfe6.png\" style=\"vertical-align:middle\" \/><br \/>杨辉",
      "<img alt=\"菁优网\" src=\"http:\/\/img.jyeoo.net\/quiz\/images\/202109\/91\/104953d5.png\" style=\"vertical-align:middle\" \/><br \/>祖冲之",
      "<img alt=\"菁优网\" src=\"http:\/\/img.jyeoo.net\/quiz\/images\/202109\/91\/5d6e4141.png\" style=\"vertical-align:middle\" \/><br \/>秦九韶",
      "<img alt=\"菁优网\" src=\"http:\/\/img.jyeoo.net\/quiz\/images\/202109\/91\/2ac1551c.png\" style=\"vertical-align:middle\" \/><br \/>刘徽"
    ],
    "answers": [
      "3"
    ],
    "method": "解：刘徽给《九章算术》写过注文，《海岛算经》是刘徽所著，<br \/>故选：D．",
    "analyse": "根据课本上的读一读，可以得到答案．",
    "discuss": "本题考查了数学常识，数学文化，熟记课本上的数学文化是解题的关键．",
    "category": {
      "id": 1,
      "title": "选择题",
      "is_objective": true
    }
  },
  {
    "id": 325,
    "content": "<img alt=\"菁优网\" src=\"http:\/\/img.jyeoo.net\/quiz\/images\/202108\/274\/faa6a735.png\" style=\"vertical-align:middle;FLOAT:right\" \/>《几何原本》是欧几里得的一部不朽之作．本书以公理和原始概念为基础．推演出更多的结论，这种做法为人们提供了一种研究问题的方法．这种方法所体现的数学思想是（　　）",
    "options": [
      "数形结合思思",
      "分类讨论思想",
      "转化思想",
      "公理化思想"
    ],
    "answers": [
      "3"
    ],
    "method": "解：这种方法所体现的数学思想是公理化思想．<br \/>故选：D．",
    "analyse": "公理化思想是指以某些命题为前提，只用它们，不用其他假设进行推理而建立数学理论的思想．支撑近现代数学的基本思想．",
    "discuss": "本题考查了《几何原本》，早在公元前3世纪，希腊数学家欧几里得用由反复实践所证实而被认为不需要证明的少数命题为前提，用逻辑推理的方法，将前人在几何方面的研究成果整理成《几何原本》，这些少数命题被称为公理或公设．20 世纪 60 年代以来，许多数学家主张在中学数学中介绍公理化思想，并在一些新编教材中有所体现．中国也在中学几何教材中渗透公理化思想．",
    "category": {
      "id": 1,
      "title": "选择题",
      "is_objective": true
    }
  }
]
```