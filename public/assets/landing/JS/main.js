import { initializeApp } from "https://www.gstatic.com/firebasejs/9.5.0/firebase-app.js";
import {
  getAuth,
  signInWithRedirect,
  GoogleAuthProvider,
  FacebookAuthProvider,
  getRedirectResult,
} from "https://www.gstatic.com/firebasejs/9.5.0/firebase-auth.js";
import { validateSignUpForm } from "./form-validators.js";
import { getCountry } from "./translator.js";

const firebaseConfig = {
  apiKey: "AIzaSyCKNgZkZQgIiteir-WONr2KCJ-ki1AFI-8",
  authDomain: "seller-portal-e8cce.firebaseapp.com",
  projectId: "seller-portal-e8cce",
  storageBucket: "seller-portal-e8cce.appspot.com",
  messagingSenderId: "566278784248",
  appId: "1:566278784248:web:4922c499ea4b1850d7270d",
  measurementId: "G-53X8ZECQHP",
};

const firebaseApp = initializeApp(firebaseConfig);
const GoogleProvider = new GoogleAuthProvider();
const FacebookProvider = new FacebookAuthProvider();
const auth = getAuth(firebaseApp);

let facebookBTN = document.querySelectorAll(".facebookBTN");
let gmailBTN = document.querySelectorAll(".gmailBTN");
let signUpForm1 = document.getElementById("form-signup-1");
let signUpForm2 = document.getElementById("form-signup-2");
let goToSignupBTN = document.querySelectorAll(".signup-btn");
let goToSigninBTN = document.querySelectorAll(".header-button");
let openHelpSectionBTN = document.querySelectorAll(".FAQ-button");
let openPrivacyPolicyBTN = document.querySelector("#privacy-policy");
let openHelpBookBTN = document.querySelector("#help-book");
let facebookIcon = document.querySelectorAll(".facebook-icon");
let youtubeIcon = document.querySelectorAll(".youtube-icon");
let instagramIcon = document.querySelectorAll(".instagram-icon");
let alkasebaVido = document.querySelector("#alkaseba-video");

// Scroll Events needed Variables
let scrolling = false;

let welcomeSection = false;
let processSection = false;
let whySection = false;
let lastSection = false;

let timer = null;
let sections = document.querySelectorAll(".tracking-section");
let sectionsTopPositions = [];
let windowScrollTopPositionNow = 0;

//
let isSubmitButtonClicked = false;

let authType;

let contentContainerKey = "content-container";
let loadingContainerKey = "loading-container";

function checkCookies() {
  if (!navigator.cookieEnabled) {
    alert(
      "Cookies Required please enable cookies in your browser to apple to use our website"
    );
  }
}
getCountry();
checkCookies();

// ######facebook#######
for (let i = 0; i < facebookBTN.length; i++) {
  facebookBTN[i].addEventListener("click", function () {
    try {
      checkCookies();
      mixpanel.track("Click Landing Facebook Button");
      amplitude.getInstance().logEvent("Click Landing Facebook Button", {
        Engagement: true,
      });
      signInWithRedirect(auth, FacebookProvider).then(user => {
        // You can now link the pending credential from the first
        // error.
        user.linkWithCredential(error.credential)
      }).catch((err) => {
        console.log(err);
        alert(err.code)
        if (err.code == "auth/account-exists-with-different-credential") {
          alert(`هذا الايميل مسجل بالفعل بطريقة دخول أخري `)
        }
      });
      localStorage.setItem("redirected", "true");
      localStorage.setItem("auth_type", "facebook");
    } catch (e) {
      alert(e);
      console.log("tesssssssssssssssst try err")
    }
  });
}

// ######gmail#######
for (let i = 0; i < gmailBTN.length; i++) {
  gmailBTN[i].addEventListener("click", function () {
    try {
      checkCookies();
      mixpanel.track("Click Landing Google Button");
      amplitude.getInstance().logEvent("Click Landing Google Button", {
        Engagement: true,
      });

      // Using signIn with redirect instead of signIn with pop up to support single tab browsers (in-app browsers mostly)
      signInWithRedirect(auth, GoogleProvider).then(user => {
        // You can now link the pending credential from the first
        // error.
        user.linkWithCredential(error.credential)
      }).catch((err) => {
        console.log(err);
        alert(err.code)
        if (err.code == "auth/account-exists-with-different-credential") {
           alert(`هذا الايميل مسجل بالفعل بطريقة دخول أخري `)
        }
      });
      localStorage.setItem("redirected", "true");
      localStorage.setItem("auth_type", "google");
    } catch (e) {
      alert(e);
    }
  });
}

function signUpFormSubmitEventListener(e) {
  try {
    e.preventDefault();
    // Signup button clicked
    isSubmitButtonClicked = true;
    mixpanel.track("Click Landing Signup Button");
    amplitude.getInstance().logEvent("Click Landing Signup Button", {
      Engagement: true,
    });
    
    const formData = new FormData(e.currentTarget);
    let data = {
      auth_type: "normal",
    };

    let validationErrors = validateSignUpForm(formData);

    let form = document.getElementById(e.currentTarget.id);
    fillFormErrors(form, validationErrors);

    for (let pair of formData.entries()) {
      data[pair[0]] = pair[1];
    }
    delete data["repassword"];
    let objJsonStr = JSON.stringify(data);
    let encodedStr = b64EncodeUnicode(objJsonStr);
    for (let key in validationErrors) {
      if (validationErrors[key]) return;
    }
    mixpanel.track("Landing normal Login Successfully");
    window.location.href =
      "https://seller.alkaseba.com/login?data=" + encodedStr;
  } catch (e) {
    alert(e);
  }
}

// ######normal#######
signUpForm1.addEventListener('submit', signUpFormSubmitEventListener);
signUpForm2.addEventListener('submit', signUpFormSubmitEventListener);

// for (let i = 0; i < formSignup.length; i++) {
//   formSignup[i].addEventListener("submit", (e) => {
//     try {
//       e.preventDefault();
//       // Signup button clicked
//       isSubmitButtonClicked = true;
//       mixpanel.track("Click Landing Signup Button");
//       amplitude.getInstance().logEvent("Click Landing Signup Button", {
//         Engagement: true,
//       });

//       const formData = new FormData(formSignup[i]);
//       let data = {
//         auth_type: "normal",
//       };

//       let validationErrors = validateSignUpForm(formData);

//       let form = document.getElementById(e.currentTarget.id);
//       fillFormErrors(form, validationErrors);

//       for (let pair of formData.entries()) {
//         data[pair[0]] = pair[1];
//       }
//       delete data["repassword"];
//       let objJsonStr = JSON.stringify(data);
//       let encodedStr = b64EncodeUnicode(objJsonStr);
//       for (let key in validationErrors) {
//         if (validationErrors[key]) return;
//       }
//       mixpanel.track("Landing normal Login Successfully");
//       window.location.href =
//         "https://seller.alkaseba.com/login?data=" + encodedStr;
//     } catch (e) {
//       alert(e);
//     }
//   });
// }

sections.forEach((section) => {
  sectionsTopPositions.push(section.offsetTop);
});


function renderLoading() {
  document.getElementById(contentContainerKey).style.display = "none";
  document.getElementById(loadingContainerKey).style.display = "flex";
}

if (localStorage.getItem("redirected") == "true") {
  renderLoading();
}

function renderBackOldContent() {
  document.getElementById(contentContainerKey).style.display = "inherit";
  document.getElementById(loadingContainerKey).style.display = "none";
}

// ###########Total Navigation###############
document.addEventListener("DOMContentLoaded", function () {
  mixpanel.track("Landing Total Navigated");
  amplitude.getInstance().logEvent("Landing Total Navigated");
});

// ###### Window fully loaded #######
window.addEventListener("load", function () {
  let loadingTime = "";
  let perfEntries = performance.getEntriesByType("navigation");
  if (perfEntries[0]) {
    loadingTime = (performance.now() - perfEntries[0].loadEventStart) / 1000;
  }
  mixpanel.track("Landing Total Navigated", {
    "Page Loading Time": loadingTime,
  });
  amplitude.getInstance().logEvent("Landing Page Fully Loaded", {
    "Page Loading Time": loadingTime,
  });
});

window.addEventListener("beforeunload", () => {
  // check if the fields are filled
  // and the submit button is not clicked
  let isFormFieldsFilled = false;
  if (!isSubmitButtonClicked) {
    const formData1 = new FormData(formSignup[0]);
    const formData2 = new FormData(formSignup[1]);
    for (var pair of formData1.entries()) {
      if (pair[1].length > 0) {
        isFormFieldsFilled = true;
      }
    }
    for (var pair of formData2.entries()) {
      if (pair[1].length > 0) {
        isFormFieldsFilled = true;
      }
    }
  }
  if (isFormFieldsFilled) {
    mixpanel.track("Landing Page Filling Fields Incomplete", {
      Engagement: true,
    });
    amplitude.getInstance().logEvent("Landing Page Filling Fields Incomplete", {
      Engagement: true,
    });
  }
});

/**
 * Detect Page Scrolling Event
 * And Partial Scrolling Event
 */
setInterval(() => {
  if (scrolling) {
    scrolling = false;
    mixpanel.track("Landing Page Scroll", {
      Engagement: true,
    });
    amplitude.getInstance().logEvent("Landing Page Scroll", {
      Engagement: true,
    });
  }
}, 1000);

function activateSection(sectionTitle) {
  if (sectionTitle === "Welcome" && !welcomeSection) {
    welcomeSection = true;
    processSection = false;
    whySection = false;
    lastSection = false;
  } else if (sectionTitle === "Process" && !processSection) {
    welcomeSection = false;
    processSection = true;
    whySection = false;
    lastSection = false;
  } else if (sectionTitle === "Why" && !whySection) {
    welcomeSection = false;
    processSection = false;
    whySection = true;
    lastSection = false;
  } else if (sectionTitle === "Last" && !lastSection) {
    welcomeSection = false;
    processSection = false;
    whySection = false;
    lastSection = true;
  }
  if (timer !== null) {
    clearTimeout(timer);
  }
  timer = setTimeout(function () {
    if (welcomeSection) {
      mixpanel.track("Welcome Section Active", {
        Engagement: true,
      });
      amplitude.getInstance().logEvent("Welcome Section Active", {
        Engagement: true,
      });
    } else if (processSection) {
      mixpanel.track("Process Section Active", {
        Engagement: true,
      });
      amplitude.getInstance().logEvent("Process Section Active", {
        Engagement: true,
      });
    } else if (whySection) {
      mixpanel.track("Why Section Active", {
        Engagement: true,
      });
      amplitude.getInstance().logEvent("Why Section Active", {
        Engagement: true,
      });
    } else if (lastSection) {
      mixpanel.track("Last Section Active", {
        Engagement: true,
      });
      amplitude.getInstance().logEvent("Last Section Active", {
        Engagement: true,
      });
    }
    welcomeSection = false;
    processSection = false;
    whySection = false;
    lastSection = false;
    timer = null;
  }, 2000);
}

function findClosestSectionToViewport(viewportTopPosition) {
  let n = sectionsTopPositions.length;

  // Top and Bottom Sections Cases
  if (viewportTopPosition <= sectionsTopPositions[0]) return 0;
  if (viewportTopPosition >= sectionsTopPositions[n - 1]) return n - 1;

  // Binary Search Code
  let i = 0,
    j = n,
    mid = 0;
  while (i < j) {
    mid = (i + j) / 2;

    if (sectionsTopPositions[mid] == viewportTopPosition) return mid;

    // If viewportTopPosition is less than sectionsTopPositionsay
    // element,then search in left
    if (viewportTopPosition < sectionsTopPositions[mid]) {
      // If viewportTopPosition is greater than previous
      // to mid, return closest of two
      if (mid > 0 && viewportTopPosition > sectionsTopPositions[mid - 1])
        return getClosest(mid - 1, mid, viewportTopPosition);

      // Repeat for left half
      j = mid;
    }

    // If viewportTopPosition is greater than mid
    else {
      if (mid < n - 1 && viewportTopPosition < sectionsTopPositions[mid + 1])
        return getClosest(mid, mid + 1, viewportTopPosition);
      i = mid + 1; // update i
    }
  }

  // Only single element left after search
  return mid;
}

function getClosest(i1, i2, viewportTopPosition) {
  if (
    viewportTopPosition - sectionsTopPositions[i1] >=
    sectionsTopPositions[i2] - viewportTopPosition
  )
    return i2;
  else return i1;
}

window.addEventListener("scroll", function () {
  scrolling = true;
  windowScrollTopPositionNow = window.scrollY;
  let closest = findClosestSectionToViewport(windowScrollTopPositionNow);
  if (closest === 0) {
    activateSection("Welcome");
  } else if (closest === 1) {
    activateSection("Process");
  } else if (closest === 2) {
    activateSection("Why");
  } else {
    activateSection("Last");
  }
});
// #########################

function b64EncodeUnicode(str) {
  // first we use encodeURIComponent to get percent-encoded UTF-8,
  // then we convert the percent encodings into raw bytes which
  // can be fed into btoa.
  return btoa(
    encodeURIComponent(str).replace(
      /%([0-9A-F]{2})/g,
      function toSolidBytes(match, p1) {
        return String.fromCharCode("0x" + p1);
      }
    )
  );
}

function fillFormErrors(formElement, validationErrors) {
  let erroredBorderColor = "#FB1B1C";
  if (validationErrors.name) {
    formElement.querySelector("#name_error").innerHTML = validationErrors.name;
    formElement.querySelector("input[name='name']").style.borderColor =
      erroredBorderColor;
  }

  if (validationErrors.phone_number) {
    formElement.querySelector("#phone_number_error").innerHTML =
      validationErrors.phone_number;
    formElement.querySelector("input[name='phone_number']").style.borderColor =
      erroredBorderColor;
  }

  if (validationErrors.email) {
    formElement.querySelector("#email_error").innerHTML =
      validationErrors.email;
    formElement.querySelector("input[name='email']").style.borderColor =
      erroredBorderColor;
  }

  if (validationErrors.password) {
    formElement.querySelector("#password_error").innerHTML =
      validationErrors.password;
    formElement.querySelector("input[name='password']").style.borderColor =
      erroredBorderColor;
  }

  if (validationErrors.repassword) {
    formElement.querySelector("#repassword_error").innerHTML =
      validationErrors.repassword;
    formElement.querySelector("input[name='repassword']").style.borderColor =
      erroredBorderColor;
  }
}

let inputs = document.querySelectorAll("input");

for (let i = 0; i < inputs.length; i++) {
  if (inputs[i].type != "submit") {
    inputs[i].addEventListener("input", (e) => {
      clearInputError(inputs[i]);
    });
  }
}

function clearInputError(inputElement) {
  let parentForm = inputElement.parentElement;
  if (parentForm)
    parentForm.querySelector(`#${inputElement.name}_error`).innerHTML = "";
  inputElement.style.borderColor = null;
}

function resolveFireBaseAuthProvider(providerId) {
  if (providerId == "google.com") return "google";
  if (providerId == "facebook.com") return "facebook";
  return null;
}

function firebaseAuthRedirectResult() {
  const auth = getAuth();
  return getRedirectResult(auth)
    .then((result) => {
      if (!result) {
        if (!localStorage.getItem("redirect")) renderBackOldContent();
        localStorage.clear();
        return;
      }

      const user = result.user;
      authType = resolveFireBaseAuthProvider(result.providerId);

      if (authType == "facebook") {
        mixpanel.track("Landing Facebook Login Successfully");
        amplitude.getInstance().logEvent("Landing Facebook Login Successfully");
      } else if (authType == "google") {
        mixpanel.track("Landing Google Login Successfully");
        amplitude.getInstance().logEvent("Landing Google Login Successfully");
      }

      var data = {
        auth_type: authType,
        uid: user.uid,
        email: user.email,
        token: user.stsTokenManager.accessToken,
        name: result._tokenResponse.fullName,
      };

      let objJsonStr = JSON.stringify(data);
      let encodedStr = b64EncodeUnicode(objJsonStr);
      window.location.href =
        "https://seller.alkaseba.com/login?data=" + encodedStr;
    })
    .catch((err) => {
      console.log(err);
      renderBackOldContent();
      const authType = localStorage.getItem("auth_type");
      localStorage.clear();
      if (err.code === "auth/account-exists-with-different-credential") {
        alert(`هذا الايميل مسجل بالفعل بطريقة دخول أخري `)
        const amplitudeSingleton = amplitude.getInstance();
        if (authType == "facebook") {
          mixpanel.track("Landing Facebook Login Failed", {
            "Facebook Login Error": err.message,
          });
          amplitudeSingleton.logEvent("Landing Facebook Login Failed", {
            "Facebook Login Error": err.message,
          });
        } else if (authType == "google") {
          mixpanel.track("Landing Google Login Failed", {
            "Google Login Error": err.message,
          });
          amplitudeSingleton.logEvent("Landing Google Login Failed", {
            "Google Login Error": err.message,
          });
        }
      }
    });
}

// ######Go To Sign up section button#######
for (let i = 0; i < goToSignupBTN.length; i++) {
  goToSignupBTN[i].addEventListener("click", function () {
    mixpanel.track("Click Landing Start Now Button", {
      Engagement: true,
    });
    amplitude.getInstance().logEvent("Click Landing Start Now Button", {
      Engagement: true,
    });
  });
}

// ######Go To Sign in  page#######
for (let i = 0; i < goToSigninBTN.length; i++) {
  goToSigninBTN[i].addEventListener("click", function () {
    mixpanel.track("Click Landing Sign In Button", {
      Engagement: true,
    });
    amplitude.getInstance().logEvent("Click Landing Sign In Button", {
      Engagement: true,
    });
  });
}

// ######Go To Help page#######
for (let i = 0; i < openHelpSectionBTN.length; i++) {
  openHelpSectionBTN[i].addEventListener("click", function () {
    mixpanel.track("Click Help Button", {
      Engagement: true,
    });
    amplitude.getInstance().logEvent("Click Help Button", {
      Engagement: true,
    });
  });
}

// ######Go To Privacy Policy page#######
openPrivacyPolicyBTN.addEventListener("click", function () {
  mixpanel.track("Click Privacy Policy Button", {
    Engagement: true,
  });
  amplitude.getInstance().logEvent("Click Privacy Policy Button", {
    Engagement: true,
  });
});

// ###### Facebook icon #######
for (let i = 0; i < facebookIcon.length; i++) {
  facebookIcon[i].addEventListener("click", function () {
    mixpanel.track("Click Landing Facebook Social Media", {
      Engagement: true,
    });
    amplitude.getInstance().logEvent("Click Landing Facebook Social Media", {
      Engagement: true,
    });
  });
}

// ###### Youtube icon #######
for (let i = 0; i < youtubeIcon.length; i++) {
  youtubeIcon[i].addEventListener("click", function () {
    mixpanel.track("Click Landing Youtube Social Media", {
      Engagement: true,
    });
    amplitude.getInstance().logEvent("Click Youtube Social Media", {
      Engagement: true,
    });
  });
}

// ###### Instagram icon #######
for (let i = 0; i < instagramIcon.length; i++) {
  instagramIcon[i].addEventListener("click", function () {
    mixpanel.track("Click Landing Instagram Social Media", {
      Engagement: true,
    });
    amplitude.getInstance().logEvent("Click Instagram Social Media", {
      Engagement: true,
    });
  });
}

// ########### Click Video ############
alkasebaVido.addEventListener("click", function () {
  mixpanel.track("Click Video", {
    Engagement: true,
  });
  amplitude.getInstance().logEvent("Click Video", {
    Engagement: true,
  });
});

// ########### Play Video ############
alkasebaVido.addEventListener("play", function () {
  mixpanel.track("Play Video", {
    Engagement: true,
  });
  amplitude.getInstance().logEvent("Play Video", {
    Engagement: true,
  });
});

// ########### Video played ############
alkasebaVido.addEventListener("pause", function () {
  mixpanel.track("Alkaseba Video Played", {
    "Video Played Time": alkasebaVido.currentTime,
    Engagement: true,
  });
  amplitude.getInstance().logEvent("Alkaseba Video Played", {
    "Video Played Time": alkasebaVido.currentTime,
    Engagement: true,
  });
});
firebaseAuthRedirectResult();
