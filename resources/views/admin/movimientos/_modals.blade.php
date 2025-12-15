{{-- *********************************************** --}}
{{-- MODAL PARA AÑADIR MOVIMIENTO (INGRESO) --}}
{{-- *********************************************** --}}
<div id="ingreso-modal-overlay" class="offcanvas-overlay">
    <div id="ingreso-modal" class="offcanvas-panel" style="max-width: 500px; padding: 20px;">
        @include('admin.movimientos._movimiento_form', ['tipo' => 'Ingreso'])
    </div>
</div>

{{-- *********************************************** --}}
{{-- MODAL PARA AÑADIR MOVIMIENTO (GASTO) --}}
{{-- *********************************************** --}}
<div id="gasto-modal-overlay" class="offcanvas-overlay">
    <div id="gasto-modal" class="offcanvas-panel" style="max-width: 500px; padding: 20px;">
        @include('admin.movimientos._movimiento_form', ['tipo' => 'Gasto'])
    </div>
</div>

{{-- *********************************************** --}}
{{-- MODAL DE EDICIÓN DE MOVIMIENTO (CORREGIDO) --}}
{{-- *********************************************** --}}
<div class="offcanvas-overlay" id="edit-movimiento-modal-overlay">
    {{-- AQUI DEBE ESTAR EL PANEL, NO OTRO OVERLAY --}}
    <div class="offcanvas-panel" style="max-width: 500px; padding: 20px;">
        @include('admin.movimientos._edit_form_content', ['cuentas' => App\Models\CuentaContable::orderBy('nombre')->get()])
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- Lógica de Cierre de Modales (Incluye el nuevo modal) ---
        
        const ingresoOverlay = document.getElementById('ingreso-modal-overlay');
        const gastoOverlay = document.getElementById('gasto-modal-overlay');
        const editOverlay = document.getElementById('edit-movimiento-modal-overlay'); // <-- NUEVO

        function setupModalCloser(overlayId) {
            const overlay = document.getElementById(overlayId);
            if (!overlay) return;

            // 1. Cierre al hacer clic en la 'X' o Cancelar
            overlay.querySelectorAll('.close-offcanvas-btn, .cancel-movimiento-btn, .close-modal-btn').forEach(btn => { // <- Añadido .close-modal-btn
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    overlay.classList.remove('active');
                });
            });

            // 2. Cierre al hacer clic en el overlay (excepto el panel)
            overlay.addEventListener('click', (e) => {
                if (e.target === overlay) {
                    overlay.classList.remove('active');
                }
            });
            
            // 3. Evitar que el panel se cierre si se hace clic dentro de él
            overlay.querySelector('.offcanvas-panel').addEventListener('click', (e) => {
                e.stopPropagation();
            });
        }

        // Aplicar la lógica de cierre a los tres modales
        setupModalCloser('ingreso-modal-overlay');
        setupModalCloser('gasto-modal-overlay');
        setupModalCloser('edit-movimiento-modal-overlay'); // <-- APLICAR CERRAR AL MODAL DE EDICIÓN
        
        // El resto de la lógica de edición (la de rellenar los campos) debe quedar 
        // en el script de movimientos.index.blade.php.
    });
</script>