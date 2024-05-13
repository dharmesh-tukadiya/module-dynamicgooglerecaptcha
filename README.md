## Magento 2 Module: Dynamic Google reCAPTCHA

This module integrates Dynamic Google reCAPTCHA with your Magento 2 store's frontend forms to enhance security against spam and abuse.
It allows you to dynamically load and configure Google reCAPTCHA on any form on any frontend controller(URL).
You can add Google reCAPTCHA verfication to any frontend url.

### Features

- **Dynamic Configuration**: Configure Google reCAPTCHA settings dynamically based on specific conditions.
- **Enhanced Security**: Protect your Magento forms from spam and abuse with Google's advanced reCAPTCHA.
- **Customization**: Easily customize reCAPTCHA settings through Magento's admin panel. Allows you to select google recaptcha v2 checkbox, v2 invisible and b3 invisible.
- **Theme Compatibility** : "Luma Theme Compatible, Also Works With Hyva Themes."
  
### Configuration

After installing the module, configure it by following these steps:

![image](https://github.com/dharmesh-tukadiya/module-dynamicgooglerecaptcha/assets/140082778/721276a5-a282-45b8-b13f-fb85b1f340d9)
![image](https://github.com/dharmesh-tukadiya/module-dynamicgooglerecaptcha/assets/140082778/f372dbcc-d6ec-4ebe-8d4e-0a38d1b5cb3d)
![image](https://github.com/dharmesh-tukadiya/module-dynamicgooglerecaptcha/assets/140082778/d5f2b7b3-d738-43af-9a12-2e971cd9c6f1)
![image](https://github.com/dharmesh-tukadiya/module-dynamicgooglerecaptcha/assets/140082778/f306f2b5-5beb-49f9-86ab-b44f3d5ddd21)
Paste Below Content & Save
```html
<form action="dynamic_captcha/render/captchatest" id="custom-page-form" method="post">
    <input type="text" name="name" placeholder="Enter your name">
    <input type="submit" name="submit" id="submit">
    <div id="gcaptchacontainer"></div>
</form>
```
Open CMS Page On Front.
Check with differnt Google Recaptcha Versions and see the response After submit.




### Usage

Once configured, the Dynamic Google reCAPTCHA will automatically integrate with the specified forms on your Magento 2 store. Users will encounter the reCAPTCHA challenge based on the configured conditions.

### Compatibility

This module is compatible with Magento 2.4.x versions. Below versions are not tested.

### Support

For any issues or questions regarding this module, please [create an issue](https://github.com/dharmesh-tukadiya/module-dynamicgooglerecaptcha/issues) on GitHub or contact the module author.

### Contribution

Contributions are welcome! If you would like to improve this module, please fork the repository and submit a pull request with your changes.

### License

This module is licensed under the MIT License - see the [LICENSE](https://github.com/dharmesh-tukadiya/module-dynamicgooglerecaptcha/blob/main/LICENSE.txt) file for details.

### Author

This Magento 2 module is developed and maintained by Dharmesh N Tukadiya.

---

Thank you for using the Dynamic Google reCAPTCHA module for Magento 2. If you find it useful, consider starring the [GitHub repository](https://github.com/dharmesh-tukadiya/module-dynamicgooglerecaptcha) to show your support!
