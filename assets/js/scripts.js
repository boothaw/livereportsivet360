function isScrolledIntoView(el) {
  const rect = el.getBoundingClientRect();
  const elemTop = rect.top;
  const elemBottom = rect.bottom;

  // Only completely visible elements return true:
  const isVisible = (elemTop >= 0) && (elemBottom <= window.innerHeight);
  // Partially visible elements return true:
  //isVisible = elemTop < window.innerHeight && elemBottom >= 0;
  return isVisible;
}

function wrapNum(str) {
  return str.replace(/\d+/, '<div class="tool-used">$&</div>');
}

function reportToggle(reportClass, leftBtn, rightBtn, reportName) {

  const reportType = document.getElementsByClassName(reportClass);
  const reportNumbers = document.getElementById(reportName);
  let newNumber = 0;

  console.log(reportNumbers);

  document.getElementById(leftBtn).addEventListener('click', function() {
    newNumber = parseInt(reportNumbers.innerHTML);
    if (newNumber <= 1) {
      reportNumbers.innerHTML = reportType.length;
      reportType[0].classList.add('hidden-report');
      reportType[reportType.length - 1].classList.remove('hidden-report');
    } else {
      reportNumbers.innerHTML = newNumber -= 1;
      reportType[newNumber].classList.add('hidden-report');
      reportType[newNumber - 1].classList.remove('hidden-report');
    }
  });

  document.getElementById(rightBtn).addEventListener('click', function() {
    newNumber = parseInt(reportNumbers.innerHTML);
    console.log(newNumber);
    if (newNumber >= reportType.length) {
      reportType[reportType.length - 1].classList.add('hidden-report');
      reportType[0].classList.remove('hidden-report');
      reportNumbers.innerHTML = 1;
    } else {
      reportType[newNumber - 1].classList.add('hidden-report');
      reportType[newNumber].classList.remove('hidden-report');
      reportNumbers.innerHTML = newNumber += 1;
    }
  });

}

function viewAllBtn(viewAllBtn, reportClass, sectionName) {
  const reportType = document.getElementsByClassName(reportClass);
  const reportNumbers = document.getElementById(sectionName).querySelectorAll('.report-number')[0];
  const toggleBtns = document.getElementById(sectionName).querySelectorAll('.toggle-btns')[0];
  const toggleCover = document.getElementById(sectionName).querySelectorAll('.toggle-cover')[0];

  console.log(toggleBtns);

  document.getElementById(viewAllBtn).addEventListener('click', function() {
    console.log(this.innerHTML);
    if (this.innerHTML === 'View All') {
      this.innerHTML = 'View Less';
      reportNumbers.innerHTML = 1;
      toggleBtns.classList.add('view-all-toggle');
      toggleCover.style.display = 'block';
      for (let i = 0; i < reportType.length; i++) {
        reportType[i].classList.remove('hidden-report');
      }
    } else {
      this.innerHTML = 'View All';
      toggleBtns.classList.remove('view-all-toggle');
      toggleCover.style.display = 'none';
      for (let i = 1; i < reportType.length; i++) {
        reportType[i].classList.add('hidden-report');
      }
    }
  });
}

window.onload = function() {
  const toolsUsed = document.getElementsByClassName('tools-used');
  const indexContainer = document.getElementById('index-container');
  const indexBtn = document.getElementById('index-btn');
  const index = document.getElementById('index');
  const scorecardToggle = document.getElementById('scorecards-toggle');
  const planToggle = document.getElementById('plan-toggle');
  const scorecardResults = document.getElementById('scorecard-results');
  const planResults = document.getElementById('plan-results');
  const planHover = document.getElementsByClassName('plan-hover');
  const indexItem = document.getElementsByClassName('index-item');

  if (document.getElementById('marketing-section')) {
    reportToggle('marketing-report', 'marketing-left', 'marketing-right', 'marketing-numbers');
    viewAllBtn('marketing-all', 'marketing-report', 'marketing-section');
  }

  if (document.getElementById('analytics-section')) {
    reportToggle('analytics-report', 'analytics-left', 'analytics-right', 'analytics-numbers');
    viewAllBtn('analytics-all', 'analytics-report', 'analytics-section');
  }

  if (document.getElementById('hr-section')) {
    reportToggle('hr-report', 'hr-left', 'hr-right', 'hr-numbers');
    viewAllBtn('hr-all', 'hr-report', 'hr-section');
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

  indexBtn.addEventListener('click', function() {
    if (indexBtn.classList.contains('rotate')) {
      indexBtn.children[0].innerHTML = 'Open Index';
      indexBtn.classList.remove('rotate');
      index.style.marginTop = 0;
      index.style.maxHeight = 0;
    } else {
      indexBtn.children[0].innerHTML = 'Close Index';
      indexBtn.classList.add('rotate');
      index.style.maxHeight = index.scrollHeight + "px";
      index.style.marginTop = '10px';
    }
  });

  scorecardToggle.addEventListener('click', function() {
    if (scorecardToggle.classList.contains('active-toggle')) {
      return;
    } else {
      planToggle.classList.remove('active-toggle');
      planResults.classList.add('hidden');
      indexContainer.classList.remove('translate-y');
      setTimeout(function() {
        planResults.style.display = 'none';
        scorecardResults.style.display = 'block';
        setTimeout(function() {
          scorecardResults.classList.remove('hidden');
          indexContainer.style.display = 'none';
        }, 50);
      }, 350);
      scorecardToggle.classList.add('active-toggle');
    }
  });

  planToggle.addEventListener('click', function() {
    if (planToggle.classList.contains('active-toggle')) {
      return;
    } else {
      scorecardToggle.classList.remove('active-toggle');
      scorecardResults.classList.add('hidden');
      setTimeout(function() {
        scorecardResults.style.display = 'none';
        planResults.style.display = 'block';
        setTimeout(function() {
          planResults.classList.remove('hidden');
          indexContainer.classList.remove('translate-y');
          indexContainer.style.display = 'flex';
        }, 50);
      }, 350);
      planToggle.classList.add('active-toggle');
    }
  });

  for (let i = 0; i < planHover.length; i++) {
    planHover[i].addEventListener('mouseover', function() {
      const toolsUsed = this.querySelectorAll('.tool-used');
      for (let i = 0; i < toolsUsed.length; i++) {
        for (let j = 0; j < indexItem.length; j++) {
          if (toolsUsed[i].innerHTML === indexItem[j].getAttribute('data-id')) {
            indexItem[j].classList.add('hovered-index');
          }
        }
      }
    });

    planHover[i].addEventListener('mouseout', function() {
      for (let i = 0; i < indexItem.length; i++) {
        indexItem[i].classList.remove('hovered-index');
      }
    });
  }
}

window.onscroll = function() {
  const scrollTop = window.pageYOffset;
  const practiceGoals = document.getElementById("practice-goals");
  const indexContainer = document.getElementById('index-container');

  if (isScrolledIntoView(practiceGoals) || practiceGoals.offsetTop < scrollTop) {
    indexContainer.classList.add('translate-y');
  } else {
    indexContainer.classList.remove('translate-y');
  }
}
