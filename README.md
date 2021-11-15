# 题库 SDK
## 使用准备
申请注册一个 App
## 使用入门
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

