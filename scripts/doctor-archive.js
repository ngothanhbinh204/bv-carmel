(function () {
    var wrapper = document.querySelector('[data-doctor-archive="wrapper"]');
    if (!wrapper || typeof window.CarmelDoctorArchive === 'undefined') {
        return;
    }

    var config = window.CarmelDoctorArchive;
    var form = wrapper.querySelector('[data-doctor-search="form"]');
    var keywordInput = wrapper.querySelector('[data-doctor-search="keyword"]');
    var searchButton = wrapper.querySelector('[data-doctor-search="button"]');
    var results = wrapper.querySelector('[data-doctor-archive="results"]');
    var paginationWrap = wrapper.querySelector('[data-doctor-archive="pagination"]');
    var controller = null;
    var currentPage = 1;

    function getSpecialty() {
        var input = wrapper.querySelector('[data-dropfilter-input]');
        return input ? input.value : 'all';
    }

    function refreshLozad() {
        if (typeof window.lozad === 'function') {
            window.lozad('.lozad').observe();
        }
    }

    function setLoading(isLoading) {
        if (!results) {
            return;
        }

        results.style.opacity = isLoading ? '0.45' : '1';
    }

    function fetchDoctors(page) {
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
        data.append('keyword', keywordInput ? keywordInput.value.trim() : '');
        data.append('specialty', getSpecialty());
        data.append('paged', String(page || 1));

        setLoading(true);

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

                return response.json();
            })
            .then(function (payload) {
                if (!payload || !payload.success || !payload.data) {
                    throw new Error('Invalid response');
                }

                results.innerHTML = payload.data.grid || '<p>' + config.emptyText + '</p>';
                if (paginationWrap) {
                    paginationWrap.innerHTML = payload.data.pagination || '';
                }
                currentPage = page || 1;
                refreshLozad();
            })
            .catch(function (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                results.innerHTML = '<p>' + config.errorText + '</p>';
                if (paginationWrap) {
                    paginationWrap.innerHTML = '';
                }
            })
            .finally(function () {
                setLoading(false);
            });
    }

    if (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            fetchDoctors(1);
        });
    }

    if (searchButton) {
        searchButton.addEventListener('click', function () {
            fetchDoctors(1);
        });
    }

    wrapper.addEventListener('click', function (event) {
        var pageBtn = event.target.closest('[data-page]');
        if (!pageBtn) {
            return;
        }

        event.preventDefault();
        var nextPage = parseInt(pageBtn.getAttribute('data-page') || '1', 10);
        if (!Number.isFinite(nextPage) || nextPage < 1 || nextPage === currentPage) {
            return;
        }

        fetchDoctors(nextPage);
    });
})();
