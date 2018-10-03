# CoinHive ShortLink API
Author: @Ghost_chu

## 安装：

查看Github的WIKI章节 [Setup](https://github.com/Ghost-chu/CoinHive-ShortLink/wiki/Setup)

## 添加短链接：
POST `linkManager.php`  
### 参数：
```
type=addlink
arg={base64处理过的url}
```
### 返回：
**无异常：** 返回新增的链接的linkid(如已存在，返回已存在的链接的linkid)  
**异常：** 返回-1

## 链接转ID：
POST `linkManager.php`  
### 参数:
```
type=link2id
arg={base64处理过的url}
```
### 返回:
**无异常：** 请求的链接的linkid  
**异常（404）：** 返回-1

## ID转链接：
POST `linkManager.php`  
### 参数:
```
type=id2link
arg={linkid}
```
### 返回:
**无异常：** 请求的linkid的base64处理过的url  
**异常（404）：** 返回-1

## 访问短链接：
GET `showRedirect.php?linkid={linkid}`  

访问后参数传递到`showRedirect.php`展示Redirecting页面  
Redirecting挖矿结束后，数据POST到`jump.php`  
调用verifyCoinHive对矿池结果验证  
**未通过：** 输出`Failed to verify`  
索引数据库数据，检查是否存在 , 并取出linkid对应的link  
**不存在：** 输出`404 not found`并返回`HTTP 404`状态码  
**存在：** 解码link并header到目标站点  

## TODO:
1.  前端页面
2.	完成统计功能，目前虽然会存储数据，但是没有办法查看，你可以自己去数据库看
