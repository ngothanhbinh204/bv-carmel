(function () {
    var wrapper = document.querySelector('[data-service-archive="wrapper"]');
    if (!wrapper || typeof window.CarmelServiceArchive === 'undefined') {
        return;
    }

    var config = window.CarmelServiceArchive;
    var results = wrapper.querySelector('[data-service-archive="results"]');
    var searchButton = wrapper.querySelector('[data-service-search="button"]');
    var currentCategory = wrapper.dataset.serviceCategory || 'all';
    var form = wrapper.querySelector('.filter-bar');
    var controller = null;

    function refreshLozad() {
        if (typeof window.lozad === 'function') {
            window.lozad('.lozad').observe();
        }
    }

    function getSelectedTopic() {
        var input = wrapper.querySelector('[data-dropfilter-input]');
        return input ? input.value : 'all';
    }

    function fetchServices() {
        if (!results) {
            return;
        }

        if (controller) {
            controller.abort();
        }

        controller = new AbortController();

        var data = new FormData();
        data.append('action', config.action);
        data.append('nonce', config.nonce);
        data.append('term', currentCategory);
        data.append('topic', getSelectedTopic());
        data.append('keyword', '');

        results.classList.add('is-loading');

        fetch(config.ajaxUrl, {
            method: 'POST',
            body: data,
            credentials: 'same-origin',
            signal: controller.signal
        })
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Request failed');
                }

                return response.text();
            })
            .then(function (html) {
                results.innerHTML = html || '<p>' + config.emptyText + '</p>';
                refreshLozad();
            })
            .catch(function (error) {
                if (error.name !== 'AbortError') {
                    results.innerHTML = '<p>' + config.errorText + '</p>';
                }
            })
            .finally(function () {
                results.classList.remove('is-loading');
            });
    }

    if (searchButton) {
        searchButton.addEventListener('click', function () {
            fetchServices();
        });
    }

    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            fetchServices();
        });
    }

})();
