(function () {
    function closeAll(exceptElement) {
        document.querySelectorAll('.dropfilter-basic.is-open').forEach(function (dropdown) {
            if (dropdown !== exceptElement) {
                dropdown.classList.remove('is-open');
                var toggle = dropdown.querySelector('.dropfilter-toggle');
                if (toggle) {
                    toggle.setAttribute('aria-expanded', 'false');
                }
            }
        });
    }

    function setDropdownValue(dropdown, value, label) {
        var input = dropdown.querySelector('[data-dropfilter-input]');
        var selectedText = dropdown.querySelector('.selected-text');

        if (input) {
            input.value = value;
        }

        if (selectedText && label) {
            selectedText.textContent = label;
        }

        dropdown.querySelectorAll('.dropfilter-menu a').forEach(function (item) {
            item.parentElement.classList.toggle('active', item.dataset.value === value);
        });
    }

    document.addEventListener('click', function (event) {
        var toggle = event.target.closest('.dropfilter-toggle');
        var option = event.target.closest('.dropfilter-menu a');
        var dropdown = event.target.closest('.dropfilter-basic');

        if (toggle && dropdown) {
            event.preventDefault();
            var isOpen = dropdown.classList.contains('is-open');
            closeAll(dropdown);
            dropdown.classList.toggle('is-open', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
            return;
        }

        if (option && dropdown) {
            event.preventDefault();
            setDropdownValue(dropdown, option.dataset.value || 'all', option.dataset.label || option.textContent.trim());
            dropdown.classList.remove('is-open');
            var dropdownToggle = dropdown.querySelector('.dropfilter-toggle');
            if (dropdownToggle) {
                dropdownToggle.setAttribute('aria-expanded', 'false');
            }
        }

        if (!event.target.closest('.dropfilter-basic')) {
            closeAll();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeAll();
        }
    });

    document.querySelectorAll('.dropfilter-basic').forEach(function (dropdown) {
        var input = dropdown.querySelector('[data-dropfilter-input]');
        if (input && input.value) {
            var activeOption = dropdown.querySelector('.dropfilter-menu a[data-value="' + input.value + '"]');
            if (activeOption) {
                setDropdownValue(dropdown, input.value, activeOption.dataset.label || activeOption.textContent.trim());
            }
        }
    });
})();
