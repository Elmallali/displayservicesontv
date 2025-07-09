@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 700px;
        margin: 3rem auto;
        padding: 2rem;
        background: rgba(51, 148, 205, 0.18);
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.3);
        color: #f0f0f0;
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
    }

    input, select {
        width: 100%;
        padding: 10px;
        margin-bottom: 16px;
        border-radius: 6px;
        border: none;
        outline: none;
    }

    .btn-submit {
        background: linear-gradient(135deg, #3394cd, #82CEF9);
        color: white;
        padding: 10px 18px;
        font-weight: 600;
        border: none;
        border-radius: 8px;
        transition: background 0.3s ease;
    }

    .btn-submit:hover {
        background: linear-gradient(135deg, #1c3139, #2a4b57);
    }
</style>

<div class="form-container">
    <h2 class="text-center mb-4">Modifier Élève</h2>

    <form action="{{ route('eleves.update', $eleve) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="nom">Nom</label>
        <input type="text" name="nom" id="nom" value="{{ $eleve->nom }}" required>

        <label for="prenom">Prénom</label>
        <input type="text" name="prenom" id="prenom" value="{{ $eleve->prenom }}" required>

        <label for="sexe">Sexe</label>
        <select name="sexe" id="sexe" required>
            <option value="homme" {{ $eleve->sexe === 'homme' ? 'selected' : '' }}>Homme</option>
            <option value="femme" {{ $eleve->sexe === 'femme' ? 'selected' : '' }}>Femme</option>
        </select>

        <label for="telephone">Téléphone</label>
        <input type="text" name="telephone" id="telephone" value="{{ $eleve->telephone }}">

        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ $eleve->email }}">

        <input type="hidden" name="langue_suivie" value="Voir formations" required>

        <label>Formations disponibles</label>
        <div style="margin-bottom: 20px; background: rgba(255, 255, 255, 0.1); padding: 15px; border-radius: 8px;">
            <div style="margin-bottom: 15px;">
                <input type="text" id="searchFormation" placeholder="Rechercher une formation..." style="width: 100%; padding: 8px; border-radius: 6px; border: none; background: rgba(255, 255, 255, 0.2); color: white;">
            </div>
            
            @if($formations->count() > 0)
                <div style="max-height: 300px; overflow-y: auto;">
                    <div id="formationsList">
                        @foreach($formations as $formation)
                            <div class="formation-item" data-id="{{ $formation->id }}" data-name="{{ $formation->nom }}" data-langue="{{ $formation->langue }}" data-niveau="{{ $formation->niveau_langue }}">
                                <div class="form-check">
                                    <input type="checkbox" name="formations[]" id="formation-{{ $formation->id }}" value="{{ $formation->id }}" class="form-check-input formation-checkbox" {{ in_array($formation->id, $eleveFormations) ? 'checked' : '' }}>
                                    <label for="formation-{{ $formation->id }}" style="font-weight: normal; margin-left: 8px;">
                                        <strong>{{ $formation->nom }}</strong> - {{ $formation->langue }} ({{ $formation->niveau_langue }}) - 
                                        @if(in_array($formation->id, $eleveFormations))
                                            <span style="color: #4FBAEE;">Inscrit</span>
                                        @else
                                            {{ $formation->places_disponibles }} place(s) disponible(s)
                                        @endif
                                        - {{ $formation->prix_mensuel }} DH/mois
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div style="margin-top: 15px;">
                    <div style="display: flex; justify-content: space-between;">
                        <div>
                            <button type="button" id="selectAll" class="btn-modern" style="background: rgba(51, 148, 205, 0.3); margin-right: 10px;">Tout sélectionner</button>
                            <button type="button" id="deselectAll" class="btn-modern" style="background: rgba(51, 148, 205, 0.3);">Tout désélectionner</button>
                        </div>
                        <div>
                            <span id="selectedCount" style="background: rgba(51, 148, 205, 0.5); padding: 5px 10px; border-radius: 4px;">0 formation(s) sélectionnée(s)</span>
                        </div>
                    </div>
                </div>
            @else
                <p>Aucune formation avec des places disponibles.</p>
            @endif
        </div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchFormation');
                const formationItems = document.querySelectorAll('.formation-item');
                const checkboxes = document.querySelectorAll('.formation-checkbox');
                const selectAllBtn = document.getElementById('selectAll');
                const deselectAllBtn = document.getElementById('deselectAll');
                const selectedCountElement = document.getElementById('selectedCount');
                
                
                function updateSelectedCount() {
                    const selectedCount = document.querySelectorAll('.formation-checkbox:checked').length;
                    selectedCountElement.textContent = selectedCount + ' formation(s) sélectionnée(s)';
                }
                
                
                updateSelectedCount();
                
                
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    
                    formationItems.forEach(item => {
                        const name = item.getAttribute('data-name').toLowerCase();
                        const langue = item.getAttribute('data-langue').toLowerCase();
                        const niveau = item.getAttribute('data-niveau').toLowerCase();
                        
                        if (name.includes(searchTerm) || langue.includes(searchTerm) || niveau.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
                
                
                selectAllBtn.addEventListener('click', function() {
                    const visibleCheckboxes = Array.from(checkboxes).filter(checkbox => {
                        return checkbox.closest('.formation-item').style.display !== 'none';
                    });
                    
                    visibleCheckboxes.forEach(checkbox => {
                        checkbox.checked = true;
                    });
                    
                    updateSelectedCount();
                });
                
                
                deselectAllBtn.addEventListener('click', function() {
                    const visibleCheckboxes = Array.from(checkboxes).filter(checkbox => {
                        return checkbox.closest('.formation-item').style.display !== 'none';
                    });
                    
                    visibleCheckboxes.forEach(checkbox => {
                        checkbox.checked = false;
                    });
                    
                    updateSelectedCount();
                });
                
                
                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', updateSelectedCount);
                });
            });
        </script>

        <button type="submit" class="btn-submit">Mettre à jour</button>
    </form>
</div>
@endsection
