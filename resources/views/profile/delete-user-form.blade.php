<x-action-section>
    <x-slot name="title">
        Eliminar Conta
    </x-slot>

    <x-slot name="description">
        Elimine permanentemente a sua conta.
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-gray-600">
            Após eliminar a sua conta, todos os seus recursos e dados serão removidos permanentemente. Antes de eliminar a conta, descarregue qualquer dado ou informação que queira manter.
        </div>

        <div class="mt-5">
            <x-danger-button wire:click="confirmUserDeletion" wire:loading.attr="disabled">
                Eliminar Conta
            </x-danger-button>
        </div>

        <!-- Modal de Confirmacao para Eliminar Utilizador -->
        <x-dialog-modal wire:model.live="confirmingUserDeletion">
            <x-slot name="title">
                Eliminar Conta
            </x-slot>

            <x-slot name="content">
                Tem a certeza de que pretende eliminar a sua conta? Após eliminar a sua conta, todos os recursos e dados serão removidos permanentemente. Introduza a sua palavra-passe para confirmar a eliminação permanente da conta.

                <div class="mt-4" x-data="{}" x-on:confirming-delete-user.window="setTimeout(() => $refs.password.focus(), 250)">
                    <x-input type="password" class="mt-1 block w-3/4"
                                autocomplete="current-password"
                                placeholder="Palavra-passe"
                                x-ref="password"
                                wire:model="password"
                                wire:keydown.enter="deleteUser" />

                    <x-input-error for="password" class="mt-2" />
                </div>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button wire:click="$toggle('confirmingUserDeletion')" wire:loading.attr="disabled">
                    Cancelar
                </x-secondary-button>

                <x-danger-button class="ms-3" wire:click="deleteUser" wire:loading.attr="disabled">
                    Eliminar Conta
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    </x-slot>
</x-action-section>



