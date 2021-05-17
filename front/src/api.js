const API_URL = process.env.VUE_APP_API;

export const API = {
    graph: {
        create:   `${API_URL}/graph`,
        all:      `${API_URL}/graphs`,
        one:      `${API_URL}/graphs/:id`,
        one_stat: `${API_URL}/graphs/:id/statistics`,
        update:   `${API_URL}/graph/:id/edit`,
        delete:   `${API_URL}/graph/:id`,
    },
    node: {
        one:      `${API_URL}/node/:id`,
        create:   `${API_URL}/node`,
        delete:   `${API_URL}/node/:id`,
        update:   `${API_URL}/node/:id/edit`,

        create_edge: `${API_URL}/node/relation`,
        delete_edge: `${API_URL}/node/relation/:id/`,
    }
}