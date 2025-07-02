/***Scroll to top */
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}
window.scrollTo(0, 0);

/***Notification Modal*/

function setNotify(event) {
    event.stopPropagation();
    var getNotification = document.getElementById("Allnotification_messages");

    if (getNotification) {
        getNotification.classList.toggle('notishow');
    }
    document.body.classList.add("no-scroll");
}
document.addEventListener("click", function () {
    var getNotification = document.getElementById("Allnotification_messages");
    if(getNotification){
        getNotification.classList.remove('notishow');
    }
    document.body.classList.remove("no-scroll");
});

/****ToolTip */
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    var tooltip = new bootstrap.Tooltip(tooltipTriggerEl);

    // Add click listener to hide tooltip
    tooltipTriggerEl.addEventListener('click', function () {
        tooltip.hide();
    });

    return tooltip;
});

/***header-search-division*/
function setSearch(event) {
    event.stopPropagation();
    var getSearch = document.getElementById("category_by_division");
    getSearch.classList.toggle('searchshow');
}
document.addEventListener("click", function () {
    var getSearch = document.getElementById("category_by_division");
    if(getSearch){
        getSearch.classList.remove('searchshow');
    }
});

// Show the button after scrolling 100px
window.onscroll = function () {
    const btn = document.getElementById("backToTopBtn");
    btn.style.display = (document.documentElement.scrollTop > 100) ? "block" : "none";
};

// Scroll smoothly to the top
function scrollToTop() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
}

// // Start of Custom file input button
// document.querySelectorAll('.file-upload-block').forEach(block => {
//     const fileInput = block.querySelector('.file-upload');
//     const fileInfo = block.querySelector('.file-info');
//     const fileUploadWrapper = block.querySelector('.file-upload-wrapper');
//     const customFileTrigger = block.querySelector('.custom-file-trigger');

//     customFileTrigger.addEventListener('click', () => fileInput.click());

//     fileInput.addEventListener('change', () => {
//         if (fileInput.files.length > 0) {
//             const fileName = fileInput.files[0].name;
//             fileInfo.innerHTML = `
// 				<div class="d-flex align-item-center gap-1 remove-file">
// 					<span class="display-file font-size-12">${fileName}</span>
// 					<i class="bi bi-trash3 text-danger font-size-12 ml-3 " style="cursor:pointer;"></i>
// 				</div>
// 				`;
//             fileInfo.style.display = 'block';
//             fileUploadWrapper.style.display = 'none';

//             fileInfo.querySelector('.remove-file').addEventListener('click', () => {
//                 fileInput.value = '';
//                 fileInfo.innerHTML = '';
//                 fileInfo.style.display = 'none';
//                 fileUploadWrapper.style.display = 'block';
//             });
//         }
//     });
// });
// // End of Custom file input button

// // Start of Toggle filter section
// function openOffcanvasFilter() {
//     document.getElementById('filterPanel').classList.add('active');
// }

// function closeOffcanvasFilter() {
//     document.getElementById('filterPanel').classList.remove('active');
// }
// // End of Toggle filter section

// // Start of Card vendor list scroll
// function matchAllScrollHeights() {
//     const scrollSections = document.querySelectorAll('.scroll-list');
//     const mainContents = document.querySelectorAll('.table-product');

//     if (window.innerWidth < 768) {
//         // Remove inline height on mobile view
//         scrollSections.forEach(section => {
//             section.style.removeProperty('height');
//         });
//     } else {
//         // Match heights on larger screens
//         for (let i = 0; i < scrollSections.length; i++) {
//             if (mainContents[i]) {
//                 const extraHeight = 20;
//                 scrollSections[i].style.height = (mainContents[i].offsetHeight + extraHeight) + 'px';
//             }
//         }
//     }
// }

// window.addEventListener('load', matchAllScrollHeights);
// window.addEventListener('resize', matchAllScrollHeights);

// End of Card vendor list scroll

// Start of Custom Multiselect Dropdown Menu

// End of Custom Multiselect Dropdown Menu

// Start of Wishlist Button
// function toggleWishlist(button) {
//     const icon = button.querySelector('span.bi');

//     // Toggle classes between heart and heart-fill
//     if (icon.classList.contains('bi-heart')) {
//         icon.classList.remove('bi-heart');
//         icon.classList.add('bi-heart-fill');
//     } else {
//         icon.classList.remove('bi-heart-fill');
//         icon.classList.add('bi-heart');
//     }
// }
function toggleWishlist(button) {
    let $icon = $(button).find('span.bi');

    if ($icon.hasClass('bi-heart')) {
        $icon.removeClass('bi-heart').addClass('bi-heart-fill');
    } else {
        $icon.removeClass('bi-heart-fill').addClass('bi-heart');
    }
}

// End of Wishlist Button

// Start of Custom Toggle Accordion
document.querySelectorAll('.custom-toggle-accordion').forEach(accordion => {
    accordion.querySelectorAll('[data-bs-toggle="collapse"]').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent default behavior
            e.stopPropagation();

            const targetId = this.getAttribute('data-bs-target');
            const targetEl = document.querySelector(targetId);

            if (targetEl.classList.contains('show')) {
                const instance = bootstrap.Collapse.getInstance(targetEl);
                if (instance) {
                    instance.hide();
                }
            } else {
                // Avoid interfering with Bootstrap's built-in logic
                bootstrap.Collapse.getOrCreateInstance(targetEl).show();
            }
        });
    });
});
// End of Custom Toggle Accordion




// js by developers

$(document).on("input", ".text-upper-case", function(){
    $(this).val(($(this).val()).toUpperCase());
});

//for select file: start
$(document).on('change', '.button-browse :file', function () {
    let input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');

    input.trigger('fileselect', [numFiles, label, input]);
});

$('.button-browse :file').on('fileselect', function (event, numFiles, label, input) {
    let val = numFiles > 1 ? numFiles + ' files selected' : label;
    input.parent('.button-browse').next(':text').val(val);
});
//for select file: end

// Function to validate file size
function validateFileSize(event) {
    const fileInput = event.target;
    // const errorMsg = fileInput.nextElementSibling;
    const maxSize = 2 * 1024 * 1024; // 2MB in bytes

    if (fileInput.files.length > 0) {
        const fileSize = fileInput.files[0].size;
        if (fileSize > maxSize) {
            alert('File size exceeds 2MB limit.');
            fileInput.value = ''; // Clear the file input

            // Get both span elements by their classes
            const spanElements = document.querySelectorAll('.help-block.rfq-file-name, .remove-rfq-file');

            // Add the class 'd-none' to each span element
            spanElements.forEach(function (element) {
                element.classList.add('d-none');
            });
        }
    }
}

// Attach event listener to all input elements of type file
document.querySelectorAll('input[type="file"]').forEach(function (input) {
    input.addEventListener('change', validateFileSize);
});

(function ($) {
    $.fn.selectOption = function (vals, multiple = false) {
        const values = multiple ? vals.split(",") : [vals];
        return this.each(function () {
            const $select = $(this);
            $select.find('option').each(function () {
                const $option = $(this);
                const isSelected = values.includes($option.val());
                $option.prop('selected', isSelected);
            });
        });
    };
    $.fn.sanitizeNumberField = function() {
        return this.each(function() {
            var inputValue = $(this).val();

            // Allow only digits and the first decimal point
            var hasDecimal = false;
            var sanitized = '';

            for (var i = 0; i < inputValue.length; i++) {
                var char = inputValue[i];
                if (char >= '0' && char <= '9') {
                    sanitized += char;
                } else if (char === '.' && !hasDecimal) {
                    sanitized += char;
                    hasDecimal = true;
                }
            }

            // Prevent the value from being just a dot
            if (sanitized === '.') {
                sanitized = '';
            }

            $(this).val(sanitized);
        });
    };
    $.fn.debounceInput = function (callback, delay) {
        return this.each(function () {
            var $el = $(this);
            var debounceTimer;

            $el.on('input', function () {
                clearTimeout(debounceTimer);
                var self = this;
                var args = arguments;
                debounceTimer = setTimeout(function () {
                    callback.apply(self, args);
                }, delay);
            });
        });
    };
    // Define disableKeyboard only once to avoid conflicts if multiple jQuery
    // versions are loaded.
    if (typeof $.fn.disableKeyboard !== 'function') {
        $.fn.disableKeyboard = function () {
            return this.each(function () {
                $(this).on('keypress', function (event) {
                    event.preventDefault();
                });
            });
        };
    }
    
})(jQuery);