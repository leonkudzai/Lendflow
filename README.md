# Lendflow New York Times Bestsellers API

##Features
- Accessing New York Times bestsellers API.
- 10 minutes caching of data.
- Validation of data.
- Rate limit of 60 requests per minute per user.
- API versioning.
- Test cases implemented

##Running test cases

php artisan test

##Usage

/api/v1/bestsellers

supported params (all params are optional)<br><br>
-title (string)<br>
-author (string)<br>
-isbn (integer) -10 or 13 digits only and can be multiple isbn seperated by semicolon e.g. 1234567890;0987654321234<br>
-offset (integer) - multiples of 20 only, default is zero

##Example

/api/v1/bestsellers?title=give%20you&author=Diana&isbn=0399178570&offset=0

##Response

{
"status": "OK",
"copyright": "Copyright (c) 2025 The New York Times Company.  All Rights Reserved.",
"num_results": 1,
"results": [
{
"title": "\"I GIVE YOU MY BODY ...\"",
"description": "The author of the Outlander novels gives tips on writing sex scenes, drawing on examples from the books.",
"contributor": "by Diana Gabaldon",
"author": "Diana Gabaldon",
"contributor_note": "",
"price": "0.00",
"age_group": "",
"publisher": "Dell",
"isbns": [
{
"isbn10": "0399178570",
"isbn13": "9780399178573"
}
],
"ranks_history": [
{
"primary_isbn10": "0399178570",
"primary_isbn13": "9780399178573",
"rank": 8,
"list_name": "Advice How-To and Miscellaneous",
"display_name": "Advice, How-To & Miscellaneous",
"published_date": "2016-09-04",
"bestsellers_date": "2016-08-20",
"weeks_on_list": 1,
"rank_last_week": 0,
"asterisk": 0,
"dagger": 0
}
],
"reviews": [
{
"book_review_link": "",
"first_chapter_link": "",
"sunday_review_link": "",
"article_chapter_link": ""
}
]
}
]
}
