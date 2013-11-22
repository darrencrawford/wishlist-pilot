Wishlist Pilot
=========
Connect your Wishlist Member to Office Autopilot / Ontraport to give you the ability to control users from inside OAP.

Zip up the files and upload to Wordpress as a plugin.

System Requirements:
1.	Wishlist Member v2.71.1330 or higher
2.	cURL 7.19.7 or higher is required for the Wishlist Member API

SETUP
1.	Install plugin
2.	Get your Wishlist API Key:
1.	Wishlist Member > Settings > Miscellaneous
3.	Goto Settings > Wishlist OAP Linker
1.	Paste your Wishlist API Key
4.	Goto OfficeAutopilot > Admin >  OfficeAutopilot API Instructions and Key Manager
1.	Generate API Key
2.	Copy API AppID and API Key to the Wordpress plugin page
5.	Enter the Thank You Page Numbers in a comma separated list.  The page numbers are for the page that a user lands on when first registering for a level.  It is recommended to have an "after registration" page that is unique to the specific level.  You can get the page ID by highlighting or clicking the page link looking for the ?post=
6.	Goto the Field Editor In OAP > Admin > Field Editor
1.	Make sure you are on the "Contact Information" section for editing.  This is the primary section that includes First, Last, Email, etc…
2.	Add a new field and call it something like 'WLM User ID'.  
3.	Create a unique name if you will be running multiple Wishlist sites since the members won't have the same user ID in each.  'WLM Site A User ID', 'WLM Site B User ID'
4.	Copy and paste it exactly to the plugin settings.
7.	Save changes.

Test that new members are being sent to OAP by registering as a new user.

Troubleshooting.
1.	New users are not being sent to OAP.
1.	Check that all the API Keys and AppID is correct.
2.	Ensure the name of the custom field is exactly the same (spaces, capitalization etc)
3.	Ensure that the "after registration" page that you are delivered to after creating a new member has the correct page # entered.
2.	I've imported users and their user ID but it does not seem to be passing the variables or tracking them.
1.	First you need to make sure that OAP "knows" who the user is.  To do this have them click on an email link that takes them to the wordpress site.  The link must be one that is tracked such as a "CLICK HERE" hypertext.  If you provide a direct url such ashttp://website.com then it may not work.
2.	Once the user clicks that link OAP will connect the dots and realize.
3.	This is generally not a problem when a user is directly created instead of being imported.

Using OfficeAutopilot to add Members to new levels.
By collecting the user ID into OAP we are able to upgrade a user's level without them being required to register as an existing user.  That process is often confusing for members.

With this process you can add users to new levels based on active responses in OAP such as clicking a specific tracked link.  (See their documentation if you are not sure how to use tracked links.)  Or you could add them in a step or date sequence such as dripped access to content.

1.	Find the SKU of the level you wish to add users to.
1.	In Wishlist Member go to Integration > Shopping Cart and choose generic.
2.	You will see a list of all your membership levels and Item/Subscription ID
3.	Copy the one you will be using for the response.
2.	In OAP click the green Automation tab
1.	Create a Step, Date or Active Response
2.	Choose a RULE (in the case of step & date sequences)
3.	Under "What should happen?" choose Ping URL.
4.	Enter the url as follows: http://yourwebsite.com/wp-content/plugins/wishlist-oap-linker/wishlist.php?UserID=[WLM User ID]&Level_Id=THE-SKU-FROM-1C
5.	replace website.com with the URL of your actual wordpress members site.
6.	for UserID=[WLM User ID] this will populate the members ID from OAP.  If you called your field something different make sure to put it in the square brackets instead.  It must be an exact match
7.	After Level_id= just put the SKU# you copied from above.
8.	Save your autopilot sequence as normal.
3.	Test your sequence by adding the user to the sequence.  Make sure you have two levels so you can see when they are added to a new one.






