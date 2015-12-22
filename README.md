# sosmed-cms
DoCoMo API Library for CMS Enterprise


## Synopsis

When the web want to simplify for login method using social media, how that is very **simple** and **easy** setup. This plugin only support for CMS Enterprise v.2.3.1 and their clients. Contact developer http://anovan.com  

## Code Example
HTTP Request
```
{BASE_DOMAIN}/api/{PROVIDER}/login/get
```

Result JSON
```
{"status":true,"url":"http:\/\/{BASE_DOMAIN}\/api\/{PROVIDER}\/callback\/data"}
```

Response Success
```json
{"status":true,"data":{"oauth_token":"568108819-zbVEFXG1UX9fvxQqSSpKY1mqJXx34o1WGaevdTl8","oauth_token_secret":"zIIWmi6XCfIedvGtJG9DIO7mqYmxt9Mu13x8h2E7jzGGj","oauth_verifier":"E8kVE4ltcSy7rGK7qTrnDnk3lhPlY957","user":{"id":568108819,"id_str":"568108819","name":"Ano Van","screen_name":"ano_van","location":"Jakarta - Indonesia","description":"I Love Code and Scripting","url":"http:\/\/t.co\/gIx3RRElgk","entities":{"url":{"urls":[{"url":"http:\/\/t.co\/gIx3RRElgk","expanded_url":"http:\/\/www.anovan.com","display_url":"anovan.com","indices":[0,22]}]},"description":{"urls":[]}},"protected":false,"followers_count":14,"friends_count":28,"listed_count":0,"created_at":"Tue May 01 11:10:33 +0000 2012","favourites_count":11,"utc_offset":25200,"time_zone":"Jakarta","geo_enabled":true,"verified":false,"statuses_count":173,"lang":"en","status":{"created_at":"Wed Sep 23 13:12:54 +0000 2015","id":646673594932596736,"id_str":"646673594932596736","text":"just simple do this","source":"Main PMP<\/a>","truncated":false,"in_reply_to_status_id":null,"in_reply_to_status_id_str":null,"in_reply_to_user_id":null,"in_reply_to_user_id_str":null,"in_reply_to_screen_name":null,"geo":null,"coordinates":null,"place":null,"contributors":null,"retweet_count":0,"favorite_count":0,"entities":{"hashtags":[],"symbols":[],"user_mentions":[],"urls":[]},"favorited":false,"retweeted":false,"lang":"en"},"contributors_enabled":false,"is_translator":false,"is_translation_enabled":false,"profile_background_color":"000000","profile_background_image_url":"http:\/\/abs.twimg.com\/images\/themes\/theme18\/bg.gif","profile_background_image_url_https":"https:\/\/abs.twimg.com\/images\/themes\/theme18\/bg.gif","profile_background_tile":false,"profile_image_url":"http:\/\/pbs.twimg.com\/profile_images\/562627993118322688\/zqQU1Noj_normal.jpeg","profile_image_url_https":"https:\/\/pbs.twimg.com\/profile_images\/562627993118322688\/zqQU1Noj_normal.jpeg","profile_banner_url":"https:\/\/pbs.twimg.com\/profile_banners\/568108819\/1422116174","profile_link_color":"FA743E","profile_sidebar_border_color":"000000","profile_sidebar_fill_color":"000000","profile_text_color":"000000","profile_use_background_image":false,"has_extended_profile":false,"default_profile":false,"default_profile_image":false,"following":false,"follow_request_sent":false,"notifications":false},"social":"twitter"}}
```

## Tests

```
{BASE_DOMAIN}/api/{PROVIDER}/login/get?test=true
```

## Contributors

Let people know how they can dive into the project, include important links to things like issue trackers, irc, twitter accounts if applicable.

## License

A short snippet describing the license (MIT, Apache, etc.)
