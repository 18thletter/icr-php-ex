icr-php-ex
==========

# Challenges and Thoughts
## Exercise 1
* **Time taken**: about 3 hours
* Requires the YouTube Data API, and it took a little while to just
  to read through the API documentation.
* Validating the URL was a lot trickier than I had first thought. There were
  quite a few cases to check for. I spent a good amount of time just typing
  in sample URLs into the browser bar.
* Validation took approximately 75% of the time it took to write the file.
  The request from the YouTube API was straightforward once I was familiar
  with the API.

## Exercise 2
* **Time taken**: about 4 hours, excluding the 4+ head-banging hours it took me
  to correctly set up Apache.
* It took me a while to just acclimate myself with PHP again. I had forgotten
  how much I liked PHP. It was refreshing to code in it again.
* PDO was new to me. I had previously only used the `mysql` and `mysqli`
  connectors. I was surprised about how easy it was to use prepared statements.
* I decided to write my login JavaScript file in a namespaced way. It might
  be unnecessary, but I thought it was cleaner that way.
* It took me over an hour to figure out how to fully get rid of a session
  cookie. `unset` didn’t work, and simply setting it to nothing also didn’t
  work. The thing that did it was setting to a time in the past.
* The database schema is in a file in this repository, but I will list it here
  as well.

  **Table: users**
  ------------
  *Field* | *Type* | *Null* | *Key* | *Default* | *Extra*
  ------|------|------|-----|---------|------
  id | int(10) unsigned | no | primary | null | auto_increment
  email | varchar(255) | no | unique | |
  password | varchar(255) | no | | |
  lastLoginDate | datetime | no | | 0000-00-00 00:00:00 |
  createdDate | datetime | no | | 0000-00-00 00:00:00 |
