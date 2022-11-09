<template>
    <div>
        <qalendar
            :events="events"
            :config="configs"
            :event-was-clicked="teste"
        />
    </div>
</template>

<script>
export default {
    data() {
        return {
            configs: {
                defaultMode: 'month',
                locale: 'pt-BR',
                isSilent: false,
                isEditable: false
            },
            events: [
                {
                    title: "Aula categoria B",
                    with: "Joab Garmier",
                    time: { start: "2022-11-16 13:00", end: "2022-11-16 13:50" },
                    color: "green",
                    isEditable: true,
                    id: "753944708f0f",
                    description: "Aula categoria B."
                },
                {
                    title: "Aula categoria A",
                    with: "Yves Cleuder",
                    time: { start: "2022-11-16 13:50", end: "2022-11-16 14:40" },
                    color: "green",
                    isEditable: true,
                    id: "5602b6f589fc"
                },
                {
                    title: "Aula categoria A",
                    with: "Yves Cleuder",
                    time: { start: "2022-11-17 13:50", end: "2022-11-17 14:40" },
                    color: "green",
                    isEditable: true,
                    id: "5602b6f589fc"
                }

            ],
        }
    },
    mounted() {},
    methods: {
        teste: function () {
            console.log('askdpoaskdpo')
        }
    }
}
</script>
