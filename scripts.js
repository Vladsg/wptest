class Application{
     static  _AJAX_URL = '/wp-admin/admin-ajax.php'
    init(){
         this._postsPagination()
         this._sendForm()
    }

    _postsPagination(){
        if (document.querySelector('.posts__pagination') != null){
            document.querySelector('body').addEventListener('click',function (e){
                if (!e.target.matches('.posts__pagination a')){
                    return
                }
                e.preventDefault()
                const xhr = new XMLHttpRequest(),
                    data = new FormData()
                data.set('action','latestNews')
                data.set('paged',e.target.innerText)
                xhr.onreadystatechange = () => {
                    if (xhr.readyState === 4 && xhr.status === 200){
                        const response = JSON.parse(xhr.response)
                        if (response.status === 'success'){
                            console.log(response.data)
                            document.querySelector('.posts').outerHTML = response.data
                        } else{
                            alert('Ошибка в получении данных')
                        }
                    } else if (xhr.readyState === 4){
                        alert('Ошибка в получении данных')
                    }
                }
                xhr.open("POST",Application._AJAX_URL)
                xhr.send(data)
            })
        }
    }
    _sendForm(){
         if (document.querySelector('.contacts form') != null){
             document.querySelector('.contacts form').addEventListener('submit',function (e){
                 e.preventDefault()
                 const xhr = new XMLHttpRequest(),
                     data = new FormData(e.target)
                 xhr.onreadystatechange = () => {
                     if (xhr.readyState === 4 && xhr.status === 200){
                         const response = JSON.parse(xhr.response)
                         if (response.status === 'success'){

                         } else if (response.status === 'error'){
                             alert(response.message)
                         }else{
                             alert('Ошибка в получении данных')
                         }
                     } else if (xhr.readyState === 4){
                         alert('Ошибка в получении данных')
                     }
                 }
                 xhr.open("POST",Application._AJAX_URL)
                 xhr.send(data)
             })
         }
    }
}

document.addEventListener('DOMContentLoaded',function (e){
    const app = new Application()
    app.init()
})