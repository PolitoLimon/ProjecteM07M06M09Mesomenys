<x-geomir-layout>
        <x-slot:header>
        <div class="flex flex-row justify-between items-center">
        <a href="{{ url('/home') }}"><img class="w-auto " src="{{asset("img/logo.png")}}">
        <a href="" ><img  class=" dark:bg-white  w-14 h-14 rounded-full border-2 items-center" src="{{ asset("img/usuario.png")}}"></a>
            
        </div>
        </x-slot>
        <x-slot:nav>
            <div class="izquierda  bg-yellow dark:bg-amber-300 flex flex-row justify-between w-3/5  rounded-lg">
                <a class="border-2 border-black  p-2 rounded-lg mr-4 ml-4 mt-2 mb-2 mr-3 hover:bg-amber-400" href="{{ url('dashboard') }}"><img class="home w-12" src="{{ asset("img/home.png") }}"></a>
                <div class="mensajes flex flex-row">
                    <a href=""><img class="notificaciones pt-3 pb-3 w-16 mt-2 pr-4 border-r-2 border-black" src="{{ asset("img/notificacion.png") }}"></a>
                    <a href=""><img class="mensajes w-14 pt-3 pr-3 mt-2 mr-4 ml-4" src="{{ asset("img/enviar.png") }}"></a>
                </div>
            </div>
            <div class="derecha h-2/5 items-center bg-yellow dark:bg-amber-300 flex flex-row pr-4 pt-2 pb-1 pl-4 w-4/12  justify-end rounded-lg" >
                <a href=""><img class="buscador w-12 pb-2 pr-2 border-r-2 border-black" src="{{ asset("img/buscar.png") }}"></a>
                <a href=""><img class="menu w-10 ml-3 " src="{{ asset("img/menu.png") }}"></a>
            </div>
        </x-slot:nav>
        <main>
            <div class="principal">
                
                <img src="{{ asset("img/") }}">

            </div>
            <div class="tabla-botones">
                <button href=""><img class="like w-10 ml-3" src="{{ asset("img/like.png") }}"></a>
                <button href=""><img class="comentarios w-10 ml-3" src="{{ asset("img/comentario.png") }}"></button>
                <button href=""><img class="favoritos w-10 ml-3" src="{{ asset("img/favorito.png") }}"></button>
                <button href=""><img class="guardados w-10 ml-3" src="{{ asset("img/guardar-instagram.png") }}"></button>
                <button href=""><img class="compartir w-10 ml-3" src="{{ asset("img/compartir.png") }}"></button>
            </div>
        </main>
        <x-slot:footer>

            <a class="border-2 rounded-lg border-white p-3 hover:bg-white hover:text-black" href="{{ url('/about') }}">ABOUT US</a>
        </x-slot:footer>
</x-geomir-layout>
