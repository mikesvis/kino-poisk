var ajaxHandler = null;

$(function () {

    // datepicker
    $('#datetimepicker').datetimepicker({
        format: 'L',
        locale: 'ru'
    });

    // отправка формы поиска
    $('#search').click(function(e){

        e.preventDefault();

        // если запрос уже есть - отменяем его
        if(ajaxHandler != null) {
            ajaxHandler.abort();
        }

        form = $("#searchForm");

        ajaxHandler = $.getJSON(form.attr('action'), form.serialize())
            .done(function(data){
                renderResult(data);
            })
            .fail(function(error) {
                errorText = error.statusText;
                switch (error.status) {
                    case 400:
                        errorText = error.responseText;
                        break;
                }
                renderError(errorText);
            });
    });

});

function renderError(errorText){
    $('#results tbody').html(`
        <tr>
            <td colspan="5"><div class="text-danger text-center">${errorText}</div></td>                            
        </tr>
    `);
}

function renderResult(data){
    result = '';
    console.log(data);
    for(i in data.items) {
        console.log(data.items[i]);
        original = (data.items[i].original != '')?`<br /><span class="small text-secondary">${data.items[i].original}</span>`:'';
        result += `
        <tr>
            <td>${data.items[i].position}</td>
            <td>${data.items[i].name}${original}</td>
            <td>${data.items[i].year}</td>
            <td>${data.items[i].raiting}</td>
            <td>${data.items[i].votes}</td>
        </tr>
        `;
    }
    $('#results tbody').html(result);
}
