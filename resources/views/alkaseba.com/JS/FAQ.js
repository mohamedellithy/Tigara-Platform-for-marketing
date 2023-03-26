import {getCountry} from "./translator.js"
let facebookIcon = document.querySelectorAll(".facebook-icon");
let youtubeIcon = document.querySelectorAll(".youtube-icon");
let instagramIcon = document.querySelectorAll(".instagram-icon");
let startNowBTN = document.querySelectorAll(".header-button");
let openPrivacyPolicyBTN = document.querySelector("#privacy-policy");
let openHelpBookBTN = document.querySelector("#help-book");

// ###### Facebook icon #######
for (let i = 0; i < facebookIcon.length; i++) {
  facebookIcon[i].addEventListener("click", function () {
    amplitude.getInstance().logEvent('Click Landing Facebook Social Media', {
      "Engagement": true
    });
  });
}

// ###### Youtube icon #######
for (let i = 0; i < youtubeIcon.length; i++) {
  youtubeIcon[i].addEventListener("click", function () {
      amplitude.getInstance().logEvent('Click Landing Youtube Social Media', {
        "Engagement": true
      });
  });
}

// ###### Instagram icon #######
for (let i = 0; i < instagramIcon.length; i++) {
  instagramIcon[i].addEventListener("click", function () {
    amplitude.getInstance().logEvent('Click Landing Instagram Social Media', {
      "Engagement": true
    });
  });
}

// ###### Start Now Button #######
for (let i = 0; i < startNowBTN.length; i++) {
  startNowBTN[i].addEventListener("click", function () {
    amplitude.getInstance().logEvent('Click Landing Start Now Button', {
      "Engagement": true
    });
  });
}

// ######Go To Privacy Policy page#######
if (openPrivacyPolicyBTN)
openPrivacyPolicyBTN.addEventListener("click", function () {
  amplitude.getInstance().logEvent('Click Privacy Policy Button', {
    "Engagement": true
  });
});

// ######Go To Help Book page#######
if (openHelpBookBTN)
openHelpBookBTN.addEventListener("click", function () {
  amplitude.getInstance().logEvent('Click Help Book Button', {
    "Engagement": true
  });
});

getCountry()