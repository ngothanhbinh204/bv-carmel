(function () {
    var wrapper = document.querySelector('[data-specialty-search="wrapper"]');
    if (!wrapper) {
        return;
    }

    var form = wrapper.querySelector('[data-specialty-search="form"]');
    var input = wrapper.querySelector('[data-specialty-search="input"]');
    var results = wrapper.querySelector('[data-specialty-search="results"]');

    if (!form || !input || !results || typeof window.SpecialtySearch === 'undefined') {
        return;
    }

    var searchConfig = window.SpecialtySearch;
    var controller = null;
    var debounceTimer = null;

    function refreshLozad() {
        if (typeof window.lozad === 'function') {
            var observer = window.lozad('.lozad');
            observer.observe();
        }
    }

    function renderLoadingState(isLoading) {
        if (isLoading) {
            results.style.opacity = '0.45';
            return;
        }

        results.style.opacity = '1';
    }

    function runSearch(keyword) {
        if (controller) {
            controller.abort();
        }

        controller = new AbortController();
        var formData = new FormData();
        formData.append('action', searchConfig.action);
        formData.append('nonce', searchConfig.nonce);
        formData.append('keyword', keyword);

        renderLoadingState(true);

        fetch(searchConfig.ajaxUrl, {
            method: 'POST',
            body: formData,
            signal: controller.signal,
            credentials: 'same-origin'
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Request failed');
                }

                return response.text();
            })
            .then(function (html) {
                results.innerHTML = html || '<p>' + searchConfig.emptyText + '</p>';
                refreshLozad();
            })
            .catch(function (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                results.innerHTML = '<p>' + searchConfig.errorText + '</p>';
            })
            .finally(function () {
                renderLoadingState(false);
            });
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        runSearch(input.value.trim());
    });

    input.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(function () {
            runSearch(input.value.trim());
        }, 250);
    });
})();
