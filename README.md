# Dat Shin Backend API

How to setup Dat Shin Backend API?

### Setup Database

- Enter PhpMyadmin / Other database management tools and create database with name `datshin` , encoding `utf8_unicode_ci`
- Import created database with `datashin.sql` from `assets` folder

### Database Configuration

- open `api/v1/config/dbconfig.php` and edit database credential with yours.

### API Testing

- Create Postman collection and import `datshin_postman_collection.json` from `assets` folder.
- See api documentation and test.

[x] TDL : Digital Ocean Space API KEY / B2 စတဲ့ api key နဲ့ listing လုပ်တဲ့အပိုင်းကို ပြင်ရမယ်။
[x] TDL : database မှာ season, episode, category, resolution နဲ့ mvtype တို့ကို ကြိုတင်ထည့်ပေးထားဖို့ လိုမယ်။ sample mysql backup file ထုတ်ပေးထားရမယ်။
[ ] TDL : upload Directory ကို constant နဲ့ အပြင်မှာ ထုတ်ပြီး သတ်မှတ်ပေးထားရမယ်။ ကိုယ် deploy လုပ်တဲ့ လိပ်စာကို ( အခုအတိုင်းက main host မှာ အဆင်ပြေပေမယ် ့sub host မှာ မရ)
[ ] Space က မတောင်းပဲ direct link ပဲ တဲ့ resturn ပြန်ပေးဖို့

### User and Ads Api

[x] user api ထည့်သွင်းပြီး
[x] ads api ထည့်သွင်းပြီး

- table အသစ်နှစ်ခုထည့်သွင်းထားပါသည်။
- sql file အသစ်ထည့်သွင်းထားပါသည်။

## subscription api

[x] subscription api ထည့်သွင်းပြီး

- table အသစ်တစ်ခုထည့်သွင်းထားပါသည်။
- sql file အသစ်ထည့်သွင်းထားပါသည်။
