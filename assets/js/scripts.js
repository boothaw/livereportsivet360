function isScrolledIntoView(el) {
  const rect = el.getBoundingClientRect();
  const elemTop = rect.top;
  const elemBottom = rect.bottom;

  // Only completely visible elements return true:
  const isVisible = elemTop >= 0 && elemBottom <= window.innerHeight;
  // Partially visible elements return true:
  //isVisible = elemTop < window.innerHeight && elemBottom >= 0;
  return isVisible;
}

function recessionReports() {
  const reports = document.querySelectorAll(".recession-page .results");

  console.log("reports", reports);

  reports.forEach(function (report) {
    const top = report.querySelector(".report-details");
    const bottom = report.querySelector(".accordion-bottom");

    console.log("top", top);
    console.log("bottom", bottom);

    top.addEventListener("click", function () {
      jQuery(bottom).slideToggle();
      jQuery(top).find("i").toggle();
    });
  });
}

function wrapNum(str) {
  return str.replace(/\d+/, '<div class="tool-used">$&</div>');
}

function reportToggle(reportClass, leftBtn, rightBtn, reportName) {
  const reportType = document.getElementsByClassName(reportClass);
  const reportNumbers = document.getElementById(reportName);
  let newNumber = 0;

  console.log(reportNumbers);

  document.getElementById(leftBtn).addEventListener("click", function () {
    newNumber = parseInt(reportNumbers.innerHTML);
    if (newNumber <= 1) {
      reportNumbers.innerHTML = reportType.length;
      reportType[0].classList.add("hidden-report");
      reportType[reportType.length - 1].classList.remove("hidden-report");
    } else {
      reportNumbers.innerHTML = newNumber -= 1;
      reportType[newNumber].classList.add("hidden-report");
      reportType[newNumber - 1].classList.remove("hidden-report");
    }
  });

  document.getElementById(rightBtn).addEventListener("click", function () {
    newNumber = parseInt(reportNumbers.innerHTML);
    console.log(newNumber);
    if (newNumber >= reportType.length) {
      reportType[reportType.length - 1].classList.add("hidden-report");
      reportType[0].classList.remove("hidden-report");
      reportNumbers.innerHTML = 1;
    } else {
      reportType[newNumber - 1].classList.add("hidden-report");
      reportType[newNumber].classList.remove("hidden-report");
      reportNumbers.innerHTML = newNumber += 1;
    }
  });
}

function viewAllBtn(viewAllBtn, reportClass, sectionName) {
  const reportType = document.getElementsByClassName(reportClass);
  const reportNumbers = document
    .getElementById(sectionName)
    .querySelectorAll(".report-number")[0];
  const toggleBtns = document
    .getElementById(sectionName)
    .querySelectorAll(".toggle-btns")[0];
  const toggleCover = document
    .getElementById(sectionName)
    .querySelectorAll(".toggle-cover")[0];

  console.log(toggleBtns);

  document.getElementById(viewAllBtn).addEventListener("click", function () {
    console.log(this.innerHTML);
    if (this.innerHTML === "View All") {
      this.innerHTML = "View Less";
      reportNumbers.innerHTML = 1;
      toggleBtns.classList.add("view-all-toggle");
      toggleCover.style.display = "block";
      for (let i = 0; i < reportType.length; i++) {
        reportType[i].classList.remove("hidden-report");
      }
    } else {
      this.innerHTML = "View All";
      toggleBtns.classList.remove("view-all-toggle");
      toggleCover.style.display = "none";
      for (let i = 1; i < reportType.length; i++) {
        reportType[i].classList.add("hidden-report");
      }
    }
  });
}

window.onload = function () {
  const toolsUsed = document.getElementsByClassName("tools-used");
  const indexContainer = document.getElementById("index-container");
  const indexBtn = document.getElementById("index-btn");
  const index = document.getElementById("index");
  const scorecardToggle = document.getElementById("scorecards-toggle");
  const planToggle = document.getElementById("plan-toggle");
  const scorecardResults = document.getElementById("scorecard-results");
  const planResults = document.getElementById("plan-results");
  const planHover = document.getElementsByClassName("plan-hover");
  const indexItem = document.getElementsByClassName("index-item");

  if (document.querySelectorAll(".recession-page .results-inner .results")) {
    recessionReports();
  }

  if (document.getElementById("marketing-section")) {
    reportToggle(
      "marketing-report",
      "marketing-left",
      "marketing-right",
      "marketing-numbers"
    );
    viewAllBtn("marketing-all", "marketing-report", "marketing-section");
  }

  if (document.getElementById("analytics-section")) {
    reportToggle(
      "analytics-report",
      "analytics-left",
      "analytics-right",
      "analytics-numbers"
    );
    viewAllBtn("analytics-all", "analytics-report", "analytics-section");
  }

  if (document.getElementById("hr-section")) {
    reportToggle("hr-report", "hr-left", "hr-right", "hr-numbers");
    viewAllBtn("hr-all", "hr-report", "hr-section");
  }

  // reportToggle('marketing-report', 'marketing-left', 'marketing-right', 0);
  // reportToggle('analytics-report', 'analytics-left', 'analytics-right', 1);
  // reportToggle('hr-report', 'hr-left', 'hr-right', 2);
  //
  // viewAllBtn('marketing-all', 'marketing-report', 0);
  // viewAllBtn('analytics-all', 'analytics-report', 1);
  // viewAllBtn('hr-all', 'hr-report', 2);

  // for (let i = 0; i < toolsUsed.length; i++) {
  //   const test = toolsUsed[i].innerHTML.split(',');
  //   let newArray = [];
  //   for (let j = 0; j < test.length; j++) {
  //     newArray.push(wrapNum(test[j]));
  //   }
  //   newArray = newArray.join('');
  //   toolsUsed[i].innerHTML = newArray;
  // }

  if (indexBtn) {
    indexBtn.addEventListener("click", function () {
      if (indexBtn.classList.contains("rotate")) {
        indexBtn.children[0].innerHTML = "Open Index";
        indexBtn.classList.remove("rotate");
        index.style.marginTop = 0;
        index.style.maxHeight = 0;
      } else {
        indexBtn.children[0].innerHTML = "Close Index";
        indexBtn.classList.add("rotate");
        index.style.maxHeight = index.scrollHeight + "px";
        index.style.marginTop = "10px";
      }
    });
  }

  if (scorecardToggle) {
    scorecardToggle.addEventListener("click", function () {
      if (scorecardToggle.classList.contains("active-toggle")) {
        return;
      } else {
        planToggle.classList.remove("active-toggle");
        planResults.classList.add("hidden");
        indexContainer.classList.remove("translate-y");
        setTimeout(function () {
          planResults.style.display = "none";
          scorecardResults.style.display = "block";
          setTimeout(function () {
            scorecardResults.classList.remove("hidden");
            indexContainer.style.display = "none";
          }, 50);
        }, 350);
        scorecardToggle.classList.add("active-toggle");
      }
    });
  }

  if (planToggle) {
    planToggle.addEventListener("click", function () {
      if (planToggle.classList.contains("active-toggle")) {
        return;
      } else {
        scorecardToggle.classList.remove("active-toggle");
        scorecardResults.classList.add("hidden");
        setTimeout(function () {
          scorecardResults.style.display = "none";
          planResults.style.display = "block";
          setTimeout(function () {
            planResults.classList.remove("hidden");
            indexContainer.classList.remove("translate-y");
            indexContainer.style.display = "flex";
          }, 50);
        }, 350);
        planToggle.classList.add("active-toggle");
      }
    });
  }

  for (let i = 0; i < planHover.length; i++) {
    planHover[i].addEventListener("mouseover", function () {
      const toolsUsed = this.querySelectorAll(".tool-used");
      for (let i = 0; i < toolsUsed.length; i++) {
        for (let j = 0; j < indexItem.length; j++) {
          if (toolsUsed[i].innerHTML === indexItem[j].getAttribute("data-id")) {
            indexItem[j].classList.add("hovered-index");
          }
        }
      }
    });

    planHover[i].addEventListener("mouseout", function () {
      for (let i = 0; i < indexItem.length; i++) {
        indexItem[i].classList.remove("hovered-index");
      }
    });
  }

  // if (document.querySelector(".page-id-159")) {
  //   const selectors = document.querySelectorAll(".gform-body .gfield_select");

  //   selectors.forEach((select) => {
  //     select.addEventListener("change", employerAutoFill);
  //   });
  // }
};

window.onscroll = function () {
  const scrollTop = window.pageYOffset;
  const practiceGoals = document.getElementById("practice-goals");
  const indexContainer = document.getElementById("index-container");

  if (practiceGoals) {
    if (
      isScrolledIntoView(practiceGoals) ||
      practiceGoals.offsetTop < scrollTop
    ) {
      indexContainer.classList.add("translate-y");
    } else {
      indexContainer.classList.remove("translate-y");
    }
  }
};

// preset copy for autofilling
const AutoFillObj = [
  {
    0: "0indeedLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1indeedLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2indeedLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0glassdoorLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1glassLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2glassdoorLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0payrangeLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1payrangeLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2payrangeLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0careerLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1careerLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2careerLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0googlereviewLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1googlereviewLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2googlereviewLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0glassdoor2Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1glassdoor2Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2glassdoor2Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0indeed2Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1indeed2Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2indeed2Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0pto/vacationLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1pto/vacationLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2pto/vacationLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0increasingptoLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1increasingptoLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2increasingptoLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0sickleaveLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1sickleaveLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2sickleaveLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0medical insuranceLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1medical insuranceLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2medical insuranceLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0dental insuranceLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1dental insuranceLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2dental insuranceLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
  {
    0: "0exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    1: "1exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
    2: "2exampleLorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor",
  },
];
var dropdownIndexNum = 0;

const employerAutoFill = (e) => {
  const dropdowns = document.querySelectorAll(".gform-body .gfield_select");
  const selected = e.target;
  const foundDropdown = [...dropdowns].find((drop) => drop.id == selected.id);
  var dropdownIndexNum = [...dropdowns].indexOf(foundDropdown);
  const textarea = selected
    .closest(".gfield")
    .nextSibling.querySelector("textarea");
  const optionIndex = selected.selectedIndex;

  textarea.value = " ";
  if (
    AutoFillObj[dropdownIndexNum] &&
    AutoFillObj[dropdownIndexNum][optionIndex]
  ) {
    textarea.value += AutoFillObj[dropdownIndexNum][optionIndex];
  } else {
    textarea.value += "uh oh! We don't have preset copy for this yet.";
  }
  // todo: on load set all text area to previous dropdown's index's first option
};
