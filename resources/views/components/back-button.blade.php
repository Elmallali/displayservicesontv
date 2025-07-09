<a href="{{ $url ?? url()->previous() }}" class="btn-back">
    <i class="fas fa-arrow-left me-2"></i>{{ $text ?? 'Retour' }}
</a>

<style>
    .btn-back {
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg, rgba(51, 148, 205, 0.1), rgba(51, 148, 205, 0.2));
        color: var(--accent-light);
        border: 1px solid rgba(79, 186, 238, 0.3);
        border-radius: 8px;
        padding: 8px 16px;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    
    .btn-back:hover {
        background: linear-gradient(135deg, rgba(51, 148, 205, 0.2), rgba(51, 148, 205, 0.3));
        color: var(--accent-light);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }
</style>
