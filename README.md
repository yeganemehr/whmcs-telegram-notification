# WHMCS Telegram Notification Module

This WHMCS module allows you to send notifications directly to your Telegram chats, keeping you informed about important events within your WHMCS system.

## Features

* Send WHMCS notifications to Telegram chats.
* Configure individual chat IDs for different notification types.
* Support for group chats with optional topic selection.
* Works with Telegram Bot Proxy for bypassing regional restrictions (see [Telegram Bot Proxy](https://github.com/yeganemehr/telegram-bot-proxy) for details).

## Installation

1. **Clone the repository:**

   ```bash
   git clone https://github.com/yeganemehr/whmcs-telegram-notification.git modules/notifications/Telegram
   ```


2. **Configure Telegram Bot:**

   * Create a Telegram bot using the [@BotFather](https://t.me/BotFather) bot.
   * Obtain your bot's access token.
   * Add your bot to the desired Telegram chat(s).

3. **WHMCS Admin Panel:**

   * Login to your WHMCS admin panel.
   * Navigate to **Setup > Notifications**.
   * Click **Configure** for the Telegram notification method.
   * Enter your bot's access token and the chat ID(s) for your desired notification types.
   * (Optional) For group chats, specify the topic where you want notifications to be posted.

### Creating Notification Rules

1. In your WHMCS admin panel, navigate to **Setup > Notifications**.
2. Click **Create New Notification Rule**.
3. Select the notification events you want to receive in Telegram.
4. For each notification event, choose the chat ID where you want it to be sent.

### Additional Notes

* This module utilizes the Telegram Bot API. Please refer to their documentation for detailed information on available features and limitations: [Telegram Bot API](https://core.telegram.org/bots/api)
* If your WHMCS website is located in a region that blocks direct access to Telegram servers, consider using the Telegram Bot Proxy project available here: [https://github.com/yeganemehr/telegram-bot-proxy](https://github.com/yeganemehr/telegram-bot-proxy)

**Please report any issues or suggestions through the GitHub repository's issue tracker.**

