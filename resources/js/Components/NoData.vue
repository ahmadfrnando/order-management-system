<template>
    <div class="mt-16">
        <div class="flex justify-center items-center w-100">
            <figure>
                <img
                    src="/images/no_data.svg"
                    alt="no-data"
                    class="mx-auto w-40 h-40"
                />
                <figcaption class="text-center text-gray-600 mt-5">
                    <slot />
                </figcaption>
            </figure>
        </div>
    </div>
</template>
