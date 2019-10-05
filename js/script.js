/*
Team Cipher 2.0's JavaScript
Date: 6/5/2018
*/

/*Zikri's Script*/

/* Form transfer */

function enquireInstrument(){
	sessionStorage.productNum = 1;
	sessionStorage.insName = document.getElementById("V_01").value;
}

function enquireInstrument2(){
	sessionStorage.productNum = 2;
	sessionStorage.insName = document.getElementById("V_02").value;
}

function enquireInstrument3(){
	sessionStorage.productNum = 3;
	sessionStorage.insName = document.getElementById("V_03").value;
}

function enquireInstrument4(){
	sessionStorage.productNum = 4;
	sessionStorage.insName = document.getElementById("V_04").value;
}

function enquireInstrument5(){
	sessionStorage.productNum = 5;
	sessionStorage.insName = document.getElementById("V_05").value;
}

function enquireInstrument11(){
	sessionStorage.productNum = 11;
	sessionStorage.insName = document.getElementById("D_01").value;
}

function enquireInstrument12(){
	sessionStorage.productNum = 12;
	sessionStorage.insName = document.getElementById("D_02").value;
}

function enquireInstrument13(){
	sessionStorage.productNum = 13;
	sessionStorage.insName = document.getElementById("D_03").value;
}

function enquireInstrument14(){
	sessionStorage.productNum = 14;
	sessionStorage.insName = document.getElementById("D_04").value;
}

function enquireInstrument15(){
	sessionStorage.productNum = 15;
	sessionStorage.insName = document.getElementById("D_05").value;
}

function enquireInstrument6(){
	sessionStorage.productNum = 6;
	sessionStorage.insName = document.getElementById("G_01").value;
}

function enquireInstrument7(){
	sessionStorage.productNum = 7;
	sessionStorage.insName = document.getElementById("G_02").value;
}

function enquireInstrument8(){
	sessionStorage.productNum = 8;
	sessionStorage.insName = document.getElementById("G_03").value;
}

function enquireInstrument9(){
	sessionStorage.productNum = 9;
	sessionStorage.insName = document.getElementById("G_04").value;
}

function enquireInstrument10(){
	sessionStorage.productNum = 10;
	sessionStorage.insName = document.getElementById("G_05").value;
}

function enquireInstrument16(){
	sessionStorage.productNum = 16;
	sessionStorage.insName = document.getElementById("K_01").value;
}

function enquireInstrument17(){
	sessionStorage.productNum = 17;
	sessionStorage.insName = document.getElementById("K_02").value;
}

function enquireInstrument18(){
	sessionStorage.productNum = 18;
	sessionStorage.insName = document.getElementById("K_03").value;
}

function enquireInstrument19(){
	sessionStorage.productNum = 19;
	sessionStorage.insName = document.getElementById("K_04").value;
}

function enquireInstrument20(){
	sessionStorage.productNum = 20;
	sessionStorage.insName = document.getElementById("K_05").value;
}

/**/

function getInquiry(){
	document.getElementById("instrument").options[sessionStorage.productNum].selected=true;
	document.getElementById("select_list").value = "RE: Enquiry on " + '"' + sessionStorage.insName + '"';
	sessionStorage.clear();
}

function openTab(evt,tabName){
	var x, y, ziktabs, TabLinks;
	ziktabs = document.getElementsByClassName("ziktabs");
	TabLinks = document.getElementsByClassName("linkMain");
	for(x = 0;x < ziktabs.length; x++){
		ziktabs[x].style.display = "none";
	}
	for(y = 0;y < TabLinks.length; y++){
		TabLinks[y].className = TabLinks[y].className.replace(" active", "");
	}
	document.getElementById(tabName).style.display = "block";
	evt.currentTarget.className += " active";
}

function loadTab(){
	document.getElementById("selected").click();
}

/*Zikri's Script End*/

/*Raphael's Script*/

var slideIndex = 1;

function plusSlides(n) {
	showSlides(slideIndex += n);
}

function currentSlide(n) {
	showSlides(slideIndex = n);
}

function showSlides(n) {
	var i;
	var slides = document.getElementsByClassName("RWSlides");
	var dots = document.getElementsByClassName("dotindex");
	if (n > slides.length) {slideIndex = 1}
	if (n < 1) {slideIndex = slides.length}
	for (i = 0; i < slides.length; i++) {
		slides[i].style.display = "none";
	}
	for (i = 0; i < dots.length; i++) {
		dots[i].className = dots[i].className.replace(" active", "");
	}
	slides[slideIndex-1].style.display = "block";
	dots[slideIndex-1].className += " active";
}

/* Slideshow javascript resource link:https://www.w3schools.com/howto/tryit.asp?filename=tryhow_js_slideshow */

/*DOM JavaScript NavBar*/


var navLinks = ["VIOLINS", "KEYBOARDS", "DRUMS", "GUITARS"];
var navhref = ["violin.php", "keyboards.php", "drums.php", "guitars.php"];

function navInstruments()
{
	for (x = 0; x < 4; x++)
	{
		var a = document.createElement('a'); /*creates <a> element*/
		var linkText = document.createTextNode(navLinks[x]); /*Creates text of instruments for <a> element*/
		a.appendChild(linkText); /*link the title of instrument to <a> element*/
		a.title = navLinks[x]; /*Assign title for <a> element*/
		a.href = navhref[x]; /*Assign href links to <a> element*/
		document.getElementById("myDropdown").appendChild(a)
	}
}

/* When the user clicks on the button, toggle between hiding and showing the dropdown content */
function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {

    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

/*JavaScript Dropdown resource link: https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_js_dropdown */

/*Raphael's Script End*/

/*Tan's Script*/

/*Reset the purple border for error input back to no color */
function reset_color()
{
    document.getElementById("fname").style.borderColor = "";
    document.getElementById("lname").style.borderColor = "";
    document.getElementById("email").style.borderColor = "";
    document.getElementById("pnum").style.borderColor = "";
    document.getElementById("staddress").style.borderColor = "";
    document.getElementById("citytown").style.borderColor = "";
    document.getElementById("state").style.borderColor = "";
    document.getElementById("pcode").style.borderColor = "";
    document.getElementById("instrument").style.borderColor = "";
    document.getElementById("bookdate").style.borderColor = "";
    document.getElementById("rentdurat").style.borderColor = "";
	document.getElementById("select_list").style.borderColor = "";

}

var global_alert="";
function validate_form()
{

	var all_good_to_go=true;

	var first_ok = validate_first_name();
	var lname_ok = validate_last_name();
	var email_ok = validate_email();
	var phonenum_ok = validate_phone_num();
	var address_ok = validate_address();
	var citown_ok = validate_city_town();
	var state_ok = validate_state();
	var postcode_ok = validate_postcode();
	var instrument_ok=validate_music_instrument();
	var bookdate_ok = validate_booking_date();
	var rent_day_ok = validate_rent_day();
	var subject_ok=validate_subject();

	if(first_ok && lname_ok && email_ok && phonenum_ok && address_ok && citown_ok && state_ok && postcode_ok && instrument_ok && bookdate_ok && rent_day_ok && subject_ok)
	{
		all_good_to_go=true;
		alert("Booking Success");
	}

	/*Alert the error in the user input*/
	else
	{
		alert(global_alert);
		global_alert="";
		all_good_to_go=false;
	}

	return all_good_to_go;
}
function validate_first_name()
{
	var first_name=document.getElementById("fname").value;
	var first_name_check=false;
	var fname_pattern=/[A-Za-z]$/;

	/*Check if the user input has characters*/
	if (fname_pattern.test(first_name))
	{
		document.getElementById("fname").style.borderColor = "";
		first_name_check=true;
	}

	/*Check if input is empty*/
	else if(first_name=="")
	{
		global_alert=global_alert+ "Your first name cannot be empty\n";
		/*Highlight the input the user has error or empty*/
		document.getElementById("fname").style.borderColor = "purple";
		first_name_check=false;
	}

	else
	{
		global_alert=global_alert + "Your first name must be alphabet only.\n";
		document.getElementById("fname").style.borderColor = "purple";
		first_name_check=false;

	}

	return first_name_check;

}

function validate_last_name()
{
	var last_name=document.getElementById("lname").value;
	var last_name_check=false;
	var lname_pattern=/[A-Za-z]$/;

	if (lname_pattern.test(last_name))
	{
		document.getElementById("lname").style.borderColor = "";
		last_name_check=true;
	}

	/*Check if input is empty*/
	else if(last_name=="")
	{
		global_alert=global_alert+ "Your last name cannot be empty\n";
		document.getElementById("lname").style.borderColor = "purple";
		last_name_check=false;

	}

	else
	{
		global_alert=global_alert + "Your last name must be alphabet only.\n";
		document.getElementById("lname").style.borderColor = "purple";
		last_name_check=false;

	}

	return last_name_check;

}

function validate_email()
{
	var email=document.getElementById("email").value;
	email_pattern=/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-za-zA-Z0-9.-]{1,4}$/;
	var email_check=false;

	/*Check the email if its an email type*/
	if(email_pattern.test(email))
	{
		document.getElementById("email").style.borderColor = "";
		email_check=true;
	}

	else if(email=="")
	{
		global_alert=global_alert + "Your email address cannot be empty\n";
		document.getElementById("email").style.borderColor = "purple";
		email_check=false;
	}

	else
	{
		global_alert=global_alert + "The email address you enter is invalid\n";
		document.getElementById("email").style.borderColor = "purple";
		email_check=false;
	}

	return email_check;
}

function validate_phone_num()
{
	var phone_num=document.getElementById("pnum").value;
	var phone_num_check=false;

	if(phone_num=="")
	{
		global_alert=global_alert + "Your phone number cannot be empty\n";
		document.getElementById("pnum").style.borderColor = "purple";
		phone_num_check=false;


	}

	/*Check if the phone number is digit only not digit and characters*/
	else if(isNaN(phone_num))
	{
		global_alert=global_alert+ "Your phone number must be digit only\n";
		document.getElementById("pnum").style.borderColor = "purple";
		phone_num_check=false;
	}

	/*Check if the phone number is less than 10*/
	else if(phone_num.length!=10)
	{
		global_alert=global_alert + "Your phone number must be at least 10 digit\n";
		document.getElementById("pnum").style.borderColor = "purple";
		phone_num_check=false;

	}

	else
	{
		document.getElementById("pnum").style.borderColor = "";
		phone_num_check=true;
	}

	return phone_num_check;
}

function validate_address()
{
	var street_address=document.getElementById("staddress").value;
	document.getElementById("staddress").style.borderColor = "purple";
	var street_address_check=false;

	if(street_address=="")
	{
		global_alert=global_alert + "Your street address cannot be empty\n";
		document.getElementById("staddress").style.borderColor = "purple";
		street_address_check=false;
	}

	else
	{
		document.getElementById("staddress").style.borderColor = "";
		street_address_check=true;
	}

	return street_address_check;
}

function validate_city_town()
{
	var citown=document.getElementById("citytown").value;
	var citown_check=false;
	var citown_pattern=/[0-9]$/;

	if(citown=="")
	{
		global_alert=global_alert + "Your City/Town cannot be empty\n";
		document.getElementById("citytown").style.borderColor = "purple";
		citown_check=false;
	}

	/*Since no city/town has numbers in their name this check if the name of the city/town the user input has number*/
	else if(citown_pattern.test(citown))
	{
		global_alert=global_alert + "Please enter a valid city/town name\n";
		document.getElementById("citytown").style.borderColor = "purple";
		citown_check=false;
	}

	else
	{
		document.getElementById("citytown").style.borderColor = "";
		citown_check=true;
	}

	return citown_check;
}

function validate_state()
{
	var state=document.getElementById("state");
	var state_select=state.options[state.selectedIndex].value;
	var state_check=false;

	/*check if the user select one of the option from the select state*/
	if (state_select=="Johor Darul Tar zim" || state_select=="Kedah Darul Aman" || state_select =="Kedah Darul Naim" || state_select=="Kuala lumpur" || state_select=="Labuan" || state_select=="Melaka" || state_select=="Negeri Sembilan Darul Khusus" || state_select=="Pahang Darul Makmur" || state_select=="Perak Darul Ridzuan" || state_select=="Perlis Indera Kayangan" || state_select=="Penang" || state_select=="Putrajaya" || state_select=="Sarawak" || state_select=="Sabah" || state_select=="Selangor Darul Ehsan" || state_select=="Terengganu Darul Iman")
	{
		document.getElementById("state").style.borderColor = "";
		state_check=true;
	}

	else
	{
		global_alert=global_alert + "Please select your state\n";
		document.getElementById("state").style.borderColor = "purple";
		state_check=false;
	}
	return state_check;
}

function validate_postcode()
{
	var postcode=document.getElementById("pcode").value;
	var postcode_check=false;
	var postcode_pattern=/[0-9]$/;

	if (postcode=="")
	{
		global_alert=global_alert + "Your postcode cannot be empty\n";
		document.getElementById("pcode").style.borderColor = "purple";
		postcode_check=false;
	}

	/*Check if the post code is not a mixture of characters and number*/
	else if(isNaN(postcode))
	{
		global_alert=global_alert + "Please enter digit in your postcode only\n";
		document.getElementById("pcode").style.borderColor = "purple";
		postcode_check=false;
	}

	/*Check if the postcode number is less than 5*/
	else if(postcode.length<5)
	{
		global_alert=global_alert + "Your postcode must be 5 digit\n";
		document.getElementById("pcode").style.borderColor = "purple";
		postcode_check=false;
	}

	/*Check if the postcode is number and exactly 5 digit*/
	else if(postcode_pattern.test(postcode) && postcode.length==5)
	{
		document.getElementById("pcode").style.borderColor = "";
		postcode_check=true;
	}

	return postcode_check;
}

function validate_music_instrument()
{
	var instrument=document.getElementById("instrument");
	var instrument_select=instrument.options[instrument.selectedIndex].value;
	var instrument_check=false;

	/*Check if the user select a music instrument from the select music instrument option */
	if(instrument_select=="#v_01" || instrument_select=="#v_02" || instrument_select=="#v_03" || instrument_select=="#v_04" || instrument_select=="#v_05" || instrument_select=="#g_01" || instrument_select=="#g_02" || instrument_select=="#g_03" || instrument_select=="#g_04" || instrument_select=="#g_05" || instrument_select=="#d_01" || instrument_select=="#d_02" || instrument_select=="#d_03" || instrument_select=="#d_04" || instrument_select=="#d_05" || instrument_select=="#k_01" || instrument_select=="#k_02" || instrument_select=="#k_03" || instrument_select=="#k_04" || instrument_select=="#k_05")
	{
		document.getElementById("instrument").style.borderColor = "";
		instrument_check=true;
	}

	else
	{
		global_alert=global_alert + "Please select a music instrument you wish to rent\n";
		document.getElementById("instrument").style.borderColor = "purple";
		instrument_check=false;
	}

	return instrument_check;
}

function validate_booking_date()
{
		var book_date=document.getElementById("bookdate").value;
		var book_date_check=false;
		var book_date_pattern=/(0[1-9]|[12][0-9]|3[01])[/](0[1-9]|1[012])[/](19|20)\d\d$/;

		if (book_date=="")
		{
			global_alert=global_alert + "Please enter a date you wish to start booking the instrument in dd/mm/year format\n";
			document.getElementById("bookdate").style.borderColor = "purple";
			book_date_check=false;
		}

		/*Check if the user enter the date in dd/mm/year format*/
		else if(book_date_pattern.test(book_date))
		{
			document.getElementById("bookdate").style.borderColor = "";
			book_date_check=true;
		}

		/*Wrong date format*/
		else
		{
			global_alert=global_alert + "Please enter the date in dd/mm/year format\n";
			document.getElementById("bookdate").style.borderColor = "purple";
			book_date_check=false;
		}

	return book_date_check;
}

function validate_rent_day()
{
	var rent_day=document.getElementById("rentdurat").value;
	var rent_day_check=false;
	var rent_day_pattern=/[0-9]$/;

	if(rent_day=="")
	{
		global_alert=global_alert + "Your rental duration cannot be empty\n";
		document.getElementById("rentdurat").style.borderColor = "purple";
		rent_day_check=false;
	}

	/*Check if the days the user enter is only number not number and characters*/
	else if(isNaN(rent_day))
	{
		global_alert=global_alert + "Please enter digit for your rental duration as the amount of days you want to rent the instrument\n";
		document.getElementById("rentdurat").style.borderColor = "purple";
		rent_day_check=false;
	}

	else if (rent_day==0)
	{
		global_alert=global_alert + "Your rental day cannot be 0 it must be at least 1 day\n";
		document.getElementById("rentdurat").style.borderColor = "purple";
		rent_day_check=false;
	}

	/*Check if the user enter only digit in the rent day*/
	else if (rent_day_pattern.test(rent_day))
	{
		document.getElementById("rentdurat").style.borderColor = "";
		rent_day_check=true;

	}

	return rent_day_check;
}

/*Global Arrays*/
var music_instru=["Carlton CVN200-4/4 Violin Outfit","Eastman Strings Violin Outfit 1/32 Size","Eastman Strings VL100 Violin Outfit-4/4","Yamaha Silent Violin (Black)","Yamaha V5 Violin Outfit 4/4","Epiphone EJ-200 Super Jumbo Acoustic/Electric - Vintage Sunburst","Epiphone LP Custom Pro-Ebony With Gold Hardware","Fender Standard Tele-Maple Neck In Brown Sunburst","Gibson 2016 J45 Standard-Vintage Sunburst","Gibson 2017 SG Faded T W/Gigbag-Worn Brown","Mapex Tornado Rock Drum Set In Black","Mapex Tornado Rock Drum Set In Burgundy","Roland Dynamic V-Drums W/Stand","Roland TD-25KV V-Drum Kit","Yamaha DTX400K-Yamaha Electronic Drum Kit","Korg KROME-61 Music Workstation Keyboard-61 Key","Korg Stage Vintage Piano-73 Key (Black)","Yamaha 88 Key Digital Piano-Black","Yamaha PSRE453 Portable Touch Sensitive Keyboard With Adaptor","Yamaha Arius Digital Piano W/Bench-Black"];

var music_code=["#v_01","#v_02","#v_03","#v_04","#v_05","#g_01","#g_02","#g_03","#g_04","#g_05","#d_01","#d_02","#d_03","#d_04","#d_05","#k_01","#k_02","#k_03","#k_04","#k_05"];
/*Global Arrays end*/

/* To populate the drop down menu of the instrument selection */
function music_instrument_list()
{
	/*Get the select music instrument id*/
	var select_id=document.getElementById("instrument");
	/*Create the option in the html*/
	var select_instrument=document.createElement('option');
	/*Description for the option*/
	select_instrument.innerHTML="Please select a music instrument";
	/*Insert the description into the option*/
	select_id.appendChild(select_instrument);


	var optgroup_violin=document.createElement("OPTGROUP");
	optgroup_violin.setAttribute("label","Violin");
	select_id.appendChild(optgroup_violin);

	for(var i=0;i<5;i++)
	{
		var opt1=document.createElement('option');
		opt1.innerHTML=music_instru[i];
		opt1.value=music_code[i];
		optgroup_violin.appendChild(opt1);
	}

	var optgroup_guitar=document.createElement("OPTGROUP");
	optgroup_guitar.setAttribute("label","Guitar");
	select_id.appendChild(optgroup_guitar);

	for(var i=5;i<10;i++)
	{
		var opt2=document.createElement('option');
		opt2.innerHTML=music_instru[i];
		opt2.value=music_code[i];
		optgroup_guitar.appendChild(opt2);
	}

	var optgroup_drum=document.createElement("OPTGROUP");
	optgroup_drum.setAttribute("label","Drum");
	select_id.appendChild(optgroup_drum);

	for(var i=10;i<15;i++)
	{
		var opt3=document.createElement('option');
		opt3.innerHTML=music_instru[i];
		opt3.value=music_code[i];
		optgroup_drum.appendChild(opt3);
	}

	var optgroup_keyboard=document.createElement("OPTGROUP");
	optgroup_keyboard.setAttribute("label","Keyboard");
	select_id.appendChild(optgroup_keyboard);

	for(var i=15;i<20;i++)
	{
		var opt4=document.createElement('option');
		opt4.innerHTML=music_instru[i];
		opt4.value=music_code[i];
		optgroup_keyboard.appendChild(opt4);
	}
}

function input_subject_field()
{

	var selected=document.getElementById("instrument");
	var instrument="";

	if  (selected.selectedIndex>0)
	{
		instrument=selected.item(selected.selectedIndex).textContent;
	}

	document.getElementById("select_list").value="RE: Enquiry on " + '"' + instrument + '"';
}

/*Check if subject input is empty or not */
function validate_subject()
{
	var subject=document.getElementById("select_list").value;
	var subject_check;

	if(subject=="")
	{
		global_alert=global_alert + "You must select a music instrument from the select music instrument option\n";
		document.getElementById("select_list").style.borderColor = "purple";
		subject_check=false;
	}

	else
	{
		document.getElementById("select_list").style.borderColor = "";
		subject_check=true;
	}
	return subject_check;
}


/*Tan's Script End*/

/*JJ's Script*/

/*
  Team Cipher 2.0's Javascript Enhancements
  Date: 4/5/2018 3:26pm
*/

/* Hover animation */

function zoom(position){
  document.getElementById('image'+position).style.transition = "all 0.5s";
  document.getElementById('image'+position).style.width = "97.9%";
  document.getElementById('image'+position).style.margin = "1%";
  document.getElementById('desc'+position).style.transition = "all 0.5s";
  document.getElementById('desc'+position).style.opacity = 1;
}

function normal(position){
  document.getElementById('desc'+position).style.opacity = 0;
  document.getElementById('image'+position).style.width = "89.9%";
  document.getElementById('image'+position).style.margin = "5%";
}

function imageOnlyZoom(position){
  document.getElementById('image'+position).style.transition = "all 0.5s";
  document.getElementById('image'+position).style.width = "100%";
  document.getElementById('image'+position).style.margin = 0;
}

function imageOnlyNormal(position){
  document.getElementById('image'+position).style.width = "90%";
  document.getElementById('image'+position).style.margin = "5%";
}


/* Hover animation in gallery */
/* Appears in category(instruments.php) and subcategory(keyboards.php,drums.php,etc.) */
/* Triggered when the user hovers over any of the gallery images */
/* To implement this feature the programmer first has to make sure the gallery images do not take up the whole container so there is space for the image to become larger. Then using javascript to create a function that can manipulate the size and margin of the image when the user hovers over it. Another function will have to be made to reverse this manipulation when the user's cursor moves out of the object. After that a transition property can be added to make the process look smoother. For the text part, a similar setup is applied but instead of manipulating size and width the opacity is manipulated which is 0 by default. */
/* References: https://www.w3schools.com/jsref/prop_style_transition.asp */

function pageName(currentPage)
{
	var addressArray = currentPage.split('/');
  var fileName = addressArray.pop();
	return fileName;
}

function highlightMenu(allPages, currentPage)
{
  var i;

	for (i=0; i<allPages.length; i++)
	{
		if(pageName(allPages[i].href) == currentPage)
		{
      if(allPages[i].parentNode.tagName == "DIV"){
        allPages[i].className = "navHighlight";
        document.getElementById('dropbutton').style.color = "purple";
        document.getElementById('dropbutton').style.borderRadius = "5px";
      }
      else if(allPages[i].parentNode.tagName == "LI"){
        allPages[i].className = "navHighlight2";
      }
      else{
				document.getElementById('dropbutton').style.color = "purple";
        document.getElementById('dropbutton').style.borderRadius = "5px";
      }
		}
	}
}

/* Highlighting current page in nav bar */
/* Appears on top of every page */
/* Triggered depending on where the user is */
/* How this works is the file name (eg. guitars.php) is retrieved from the URL and compared with the links in the nav bar */
/* To implement this the programmer has to first retrieve the URL of the page and break it down into the file name. After that, a for loop is used to compare the file name with the links in the nav bar. An if function is also used to highlight links with different placement. */
/* References: http://www.media-division.com/automatically_highlight_current_page_in/ */

/*JJ's Script End*/

/*Responsible for loading scripts*/
/*Reference: https://stackoverflow.com/questions/16683176/add-two-functions-to-window-onload/*/

function init1(){
	showSlides(slideIndex);
}

function init2(){
	var on_sub=document.getElementById("mainform");
	on_sub.onsubmit=validate_form;
}

function init6(){
	currentPage = document.location.href;
	highlightMenu(document.getElementById("nav").getElementsByTagName("a"), pageName(currentPage));
}

function init7(){
	getInquiry();
}

function init5(){
	loadTab();
}

function init3(){
	navInstruments();
}

function init4(){
    music_instrument_list();
}


var addFunctionOnWindowLoad = function(callback){
	if(window.addEventListener){
		window.addEventListener('load',callback,false);
	}
	else{
		window.attachEvent('onload',callback);
	}
}

addFunctionOnWindowLoad(init1);
addFunctionOnWindowLoad(init2);
addFunctionOnWindowLoad(init3);
addFunctionOnWindowLoad(init4);
addFunctionOnWindowLoad(init5);
addFunctionOnWindowLoad(init6);
addFunctionOnWindowLoad(init7);
/*Load ends*/
