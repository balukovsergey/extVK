console.log('My Dasha :*');

function init() {
    if (document.querySelector("#page_wall_suggest")) {
        document.querySelector("#page_wall_suggest").addEventListener("click", action);
        console.log('My Dasha Init');
    }
}

function action() {
    var textNegative = '<span class="dh-not" id="wallHelper" style="color: red"><a href="https://vk.com/goodadsnn?w=wall-99417575_182172" style="color: red"> Писал менее недели назад</a></span>';
    var textPositive = '<span class="dh-done" id="wallHelper" style="color: green"> Писал более недели назад</span>';
    var textProgress = '<span class="dh-search" id="wallHelper" style="color: gray"> Производим поиск постов</span>';

    setTimeout(() => {
        console.log("Delayed for 1 second.");
        var frame = document.querySelector("#page_suggested_posts");

        if (frame) {
            var links = document.querySelectorAll("#page_suggested_posts .author");
            const arr = {'group' : location.pathname, 'authors' : []};

            links.forEach((item) => {
                item.parentNode.insertAdjacentHTML('beforeend', textProgress);
                console.log(item.dataset.fromId);
                arr['authors'].push(item.dataset.fromId);
                //arr[] = "Daria";
            });
            console.log('Массив пользователей' + arr);

            var resp = sendXHR('POST', 'https://balukovsergey.ru/dasha/vk_wrap/index.php', arr, links, textPositive, textNegative);
        }
    }, 2000)
}

function sendXHR(type, urlReq, body, links, textPositive, textNegative) {
    return new Promise(function (resolve, reject) {
        let xhr = new XMLHttpRequest();
        xhr.open(type, urlReq);
        let respXHR;
        xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
        xhr.onload = function () {
            if (xhr.status != 200) { // HTTP ошибка? // обработаем ошибку
                if (xhr.status >= 400) {
                    reject('Ошибка при запросе "' + action + '": ' + xhr.status);
                    return;
                } else {
                    console.log('Уведомление при запросе "' + action + '": ' + xhr.status);
                }
            }

            Object.keys(xhr.response.items).forEach(prop => {
                console.log("Строка " + xhr.response.items[prop].id);

                links.forEach((item) => {
                    if (item.dataset.fromId == xhr.response.items[prop].id) {
                        if (xhr.response.items[prop].result == true) {
                            links[prop].parentNode.childNodes.forEach(sapn => {
                                if (sapn.className == "dh-search") {
                                    console.log(sapn)
                                    sapn.parentNode.insertAdjacentHTML('beforeend', textPositive);
                                    sapn.remove()
                                }
                            })
                        } else {
                            links[prop].parentNode.childNodes.forEach(sapn => {
                                if (prop.className == "dh-search") {
                                    console.log(sapn)
                                    var textNegative = '<span class="" id="wallHelper" style="color: red"><a href="' + xhr.response.items[prop].link + '" style="color: red"> Писал менее недели назад</a></span>';
                                    sapn.parentNode.insertAdjacentHTML('beforeend', textNegative);
                                    sapn.remove()
                                }
                            })
                        }
                    }
                });
            });

            respXHR = xhr.response;
            resolve(respXHR);
            return (respXHR);
        };
        // получим ответ из xhr.response
        xhr.onprogress = function (event) { // выведем прогресс
            console.log(`Загружено ${event.loaded} из ${event.total}`);
        };
        xhr.onerror = function () { // обработаем ошибку, не связанную с HTTP (например, нет соединения)
        };
        xhr.responseType = 'json';
        xhr.send(JSON.stringify(body));
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
} else {
    init()
}
