## 题库 SDK
### 使用准备
申请注册一个 App
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
        "key": 878,
        "children": [
            {
                "id": 879,
                "sid": 878,
                "title": "1 春\/朱自清",
                "key": 879
            },
            {
                "id": 880,
                "sid": 878,
                "title": "2 济南的冬天\/老舍",
                "key": 880
            },
            {
                "id": 881,
                "sid": 878,
                "title": "3* 雨的四季\/刘湛秋",
                "key": 881
            },
            {
                "id": 882,
                "sid": 878,
                "title": "4 古代诗歌四首",
                "key": 882,
                "children": [
                    {
                        "id": 883,
                        "sid": 882,
                        "title": "观沧海\/曹操",
                        "key": 883
                    },
                    {
                        "id": 884,
                        "sid": 882,
                        "title": "闻王昌龄左迁龙标遥有此寄\/李白",
                        "key": 884
                    },
                    {
                        "id": 885,
                        "sid": 882,
                        "title": "次北固山下\/王湾",
                        "key": 885
                    },
                    {
                        "id": 886,
                        "sid": 882,
                        "title": "天净沙·秋思\/马致远",
                        "key": 886
                    }
                ]
            },
            {
                "id": 887,
                "sid": 878,
                "title": "写作 热爱生活，热爱写作",
                "key": 887
            }
        ]
    }
]
```

### 获取 Directory2
代码示例：
```php
$directories = $service->fetchDirectories2($subject_id, $grade_id, $term);
```
返回值示例：同 [获取 Directory1](#fetchDirectories1)