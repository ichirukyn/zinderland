<template>
    <div class="page-not-found d-flex justify-content-around align-items-center">
        <vue-headful
                title="404 | Страница не найдена | W&S Docs"
        />
        <div class="">
            <h1>Ошибочка 404</h1>
            <p>Сенпай, мне очень жаль, но такой страницы не существует :c <br>
                Вернуться на <b><router-link to="/">главную</router-link></b></p>
        </div>
        <img src="../../assets/404.png" style="max-width: 200px;" alt="404">

    </div>
</template>

<script>
    export default {
        name: "NotFoundPage"
    }
</script>

<style scoped>

</style>
