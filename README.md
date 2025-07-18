# 魔方v10支付宝芝麻信用实名认证插件

> 适用于 [魔方v10](https://github.com/idcsmart/ZJMF-CBAP)系统的实名认证插件，使用 **支付宝开放平台** 的芝麻信用身份认证能力，为个人与企业客户提供便捷、可靠的实名认证服务。

---

## 功能特性

- ✅ 个人实名认证：支持 `SMART_FACE`、`FACE`、`CERT_PHOTO`、`CERT_PHOTO_FACE` 等多种认证模式
- ✅ 企业实名认证：基于营业执照信息进行验证
- ✅ 二维码扫码认证：自动生成支付宝二维码，用户手机扫码即可完成认证
- ✅ 结果自动回调：内置轮询接口，实时更新认证状态
- ✅ 插件化安装：零耦合，无需修改核心代码，后台一键安装 / 卸载

## 新功能特性
✅ 智能状态检测：30秒无操作自动提示刷新
✅ 双操作按钮：支持返回编辑和下一步操作
✅ 审核状态可视化：实时显示审核倒计时
✅ 即时跳转优化：成功回调0等待跳转

## 操作指引
1. 扫描二维码启动认证流程
2. 未操作30秒后显示刷新按钮
3. 审核通过自动跳转结果页
4. 审核中可手动刷新状态

---

## 目录结构

```text
Certification_Alipay/
├── Certification_Alipay.php              # 插件主类
├── config.php                            # 可视化配置字段定义（后台展示）
├── config/                               # 默认配置
│   └── config.php                        # Alipay SDK 基础配置
├── controller/                           # 控制器
│   └── IndexController.php               # 结果查询接口 (ajax)
├── logic/                                # 业务逻辑层
│   ├── AliLogic.php                      # 认证核心逻辑  
│   ├── AlipayService.php                 # 支付宝 SDK 封装
│   └── Aop/                              # AopClient 及辅助类
└── phpqrcode/                            # 生成二维码的第三方库
```

---

## 环境要求

| 组件 | 版本 |
| ---- | ---- |
| PHP  | 7.2 及以上，建议 8.x |
| OpenSSL | 已启用 |
| cURL | 已启用 |
| BCMath | 建议启用（大数运算） |

---

## 安装步骤

1. 将整个 `Certification_Alipay` 文件夹上传/放置至系统的 `plugins/certification/` 目录下（路径可能因版本不同而略有差异）。
2. 进入后台 → 插件管理，点击 “支付宝-芝麻信用” → 安装。
3. 安装完成后，点击 “配置” 按钮，填写以下 Alipay 开放平台参数：

   | 参数 | 说明 |
   | ---- | ---- |
   | **AppID** | 支付宝开放平台应用的 AppID |
   | **接口公钥** | Alipay 公钥（或公钥证书内容） |
   | **应用私钥** | 你的应用私钥 |
   | **认证方式 (biz_code)** | 选择认证场景：`SMART_FACE` / `FACE` / `CERT_PHOTO` / `CERT_PHOTO_FACE` |

4. 保存配置后，插件即可投入使用。

:::tip
如使用 **证书模式**，请确保在 `logic/AlipayService.php` 所需的 `app_cert_path`、`alipay_cert_path`、`root_cert_path` 已正确配置。
:::

---

## 常见问题

| 问题 | 解决方案 |
| ---- | -------- |
| 提示 `应用AppID不能为空` | 请检查后台配置是否已填写正确的 AppID |
| `支付宝公钥不能为空` | 若使用公钥证书模式，请上传证书并配置相应路径 |
| 认证二维码扫描后无响应 | 检查服务器是否能访问支付宝网关；确认 `gateway_url` 未被防火墙阻断 |

---

## 贡献 & 开发

欢迎提交 Issue 与 PR。如需二次开发，可参考以下入口：

- `AliLogic.php` 负责与 Alipay 服务交互
- `AlipayService.php` 对 Alipay SDK 进行轻量封装
- `controller/IndexController.php` 提供查询接口，可根据业务需求扩展返回字段

---

## License

[MIT](LICENSE) © 2025 小原
