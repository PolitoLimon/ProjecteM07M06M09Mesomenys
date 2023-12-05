<x-geomir-layout>
   <div>
      <nav>
         <div>
            <h1>Home</h1>
         </div>
</nav>
      <main>
         <p>Lorem itsum</p>
      </main>
   </div>
</x-geomir-layout>
@can('update', $post)
    <!-- Mostra el botó d'editar post -->
@endcan

@can('update', $place)
    <!-- Mostra el botó d'editar place -->
@endcan

@can('delete', $post)
    <!-- Mostra el botó d'eliminar post -->
@endcan

@can('delete', $place)
    <!-- Mostra el botó d'eliminar place -->
@endcan

