// admin-controls.js - Full admin functionality with database save
// INCLUDING ALL CERTIFICATION FUNCTIONS

document.addEventListener('DOMContentLoaded', function() {
    // Check if admin is logged in
    const isAdmin = document.body.classList.contains('admin-logged-in');
    
    if (!isAdmin) return;
    
    console.log('🌸 Admin mode activated - Edit and Delete buttons enabled');
    
    // Add edit and delete buttons to all hobby cards
    addControlsToHobbies();
    
    // Add edit and delete buttons to all project cards
    addControlsToProjects();
    
    // Add edit and delete buttons to special skills
    addControlsToSpecialSkills();
    
    // Add edit and delete buttons to skill categories and individual skills
    addControlsToSkillCategories();
    
    // Add edit and delete buttons to education, work experience, and soft skills
    addControlsToEducation();
    addControlsToWorkExperience();
    addControlsToSoftSkills();
    
    // Add edit and delete buttons to certifications
    addControlsToCertifications();
    
    // Add "Add New" buttons to sections
    addAddNewButtons();
    addNewSectionButtons();
    
    function addControlsToHobbies() {
        document.querySelectorAll('.hobby-card').forEach((card, index) => {
            // Skip the "Insert more" or "Add New" cards
            if (card.querySelector('h3')?.textContent.includes('Insert more') || 
                card.querySelector('h3')?.textContent.includes('Add New')) {
                return;
            }
            
            // Get the actual database ID from the data-id attribute
            const hobbyId = card.dataset.id;
            
            if (hobbyId) {
                addEditButton(card, 'hobby', hobbyId);
                addDeleteButton(card, 'hobby', hobbyId);
            } else {
                console.warn('Hobby card missing data-id attribute:', card);
            }
        });
    }
    
    function addControlsToProjects() {
        document.querySelectorAll('.project-card').forEach((card, index) => {
            // Skip the "Insert more" or "Add New" cards
            if (card.querySelector('h3')?.textContent.includes('Insert more') || 
                card.querySelector('h3')?.textContent.includes('Add New')) {
                return;
            }
            
            // Get the actual database ID from the data-id attribute
            const projectId = card.dataset.id;
            
            if (projectId) {
                addEditButton(card, 'project', projectId);
                addDeleteButton(card, 'project', projectId);
            } else {
                console.warn('Project card missing data-id attribute:', card);
            }
        });
    }
    
    function addControlsToSpecialSkills() {
        document.querySelectorAll('.special-skill-card').forEach((card, index) => {
            // Skip the "Insert more" or "Add New" cards
            if (card.querySelector('h3')?.textContent.includes('Insert more') || 
                card.querySelector('h3')?.textContent.includes('Add New')) {
                return;
            }
            
            const skillId = card.dataset.id;
            if (skillId) {
                addEditButton(card, 'special', skillId);
                addDeleteButton(card, 'special', skillId);
            }
        });
    }
    
    // ===== CERTIFICATION CONTROLS =====
    function addControlsToCertifications() {
        document.querySelectorAll('.flip-card[data-cert-id]').forEach((card) => {
            // Skip the default CSC card if it doesn't have a data-cert-id
            if (card.id === 'cscCard' && !card.dataset.certId) return;
            
            const certId = card.dataset.certId;
            if (certId) {
                addCertEditButton(card, certId);
                addCertDeleteButton(card, certId);
            }
        });
    }
    
    function addCertEditButton(card, certId) {
        const editBtn = document.createElement('button');
        editBtn.className = 'admin-edit-btn';
        editBtn.innerHTML = '✎ Edit';
        editBtn.setAttribute('data-type', 'certification');
        editBtn.setAttribute('data-id', certId);
        editBtn.style.cssText = `
            position: absolute;
            top: 10px;
            right: 50px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            z-index: 100;
            opacity: 0;
            transition: opacity 0.3s;
            box-shadow: 0 2px 10px rgba(76,175,80,0.3);
        `;
        
        card.style.position = 'relative';
        card.appendChild(editBtn);
        
        card.addEventListener('mouseenter', () => {
            editBtn.style.opacity = '1';
        });
        
        card.addEventListener('mouseleave', () => {
            editBtn.style.opacity = '0';
        });
        
        editBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            window.editCertification(certId);
        });
    }
    
    function addCertDeleteButton(card, certId) {
        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'admin-delete-btn';
        deleteBtn.innerHTML = '🗑️ Delete';
        deleteBtn.setAttribute('data-type', 'certification');
        deleteBtn.setAttribute('data-id', certId);
        deleteBtn.style.cssText = `
            position: absolute;
            top: 10px;
            right: 10px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            z-index: 100;
            opacity: 0;
            transition: opacity 0.3s;
            box-shadow: 0 2px 10px rgba(244,67,54,0.3);
        `;
        
        card.appendChild(deleteBtn);
        
        card.addEventListener('mouseenter', () => {
            deleteBtn.style.opacity = '1';
        });
        
        card.addEventListener('mouseleave', () => {
            deleteBtn.style.opacity = '0';
        });
        
        deleteBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            if (!certId) {
                alert('Error: Could not find ID for this certificate');
                return;
            }
            
            const certTitle = card.querySelector('h3')?.textContent || 'this certificate';
            window.deleteCertification(certId, certTitle);
        });
    }
    // ===== END CERTIFICATION CONTROLS =====
    
    function addControlsToSkillCategories() {
        document.querySelectorAll('.skill-category').forEach((category, catIndex) => {
            // Skip any add cards
            if (category.classList.contains('add-new-card')) return;
            
            const categoryName = category.querySelector('h4')?.textContent || 'Category';
            
            // Try to get the real category ID from data attribute
            let categoryId = category.dataset.id;
            
            // If no data-id attribute, determine by category name
            if (!categoryId) {
                if (categoryName.includes('Languages')) {
                    categoryId = '1';
                } else if (categoryName.includes('Frameworks')) {
                    categoryId = '2';
                } else if (categoryName.includes('Databases') || categoryName.includes('Tools')) {
                    categoryId = '3';
                } else {
                    categoryId = (catIndex + 1).toString();
                }
            }
            
            console.log(`Category: ${categoryName}, ID: ${categoryId}`);
            
            const skillsList = category.querySelector('.skill-items');
            
            if (!skillsList) return;
            
            // Add "Add Skill" button to each category
            const addSkillBtn = document.createElement('li');
            addSkillBtn.innerHTML = '+';
            addSkillBtn.setAttribute('data-category-id', categoryId);
            addSkillBtn.setAttribute('data-category-name', categoryName);
            addSkillBtn.style.cssText = `
                background: #5d3f7e;
                color: white;
                padding: 0.25rem 1rem;
                border-radius: 40px;
                border: 1px solid #5d3f7e;
                font-size: 1.2rem;
                font-weight: bold;
                cursor: pointer;
                transition: all 0.3s;
                list-style: none;
                display: inline-block;
                margin-left: 0.5rem;
                opacity: 0.7;
            `;
            
            addSkillBtn.addEventListener('mouseenter', () => {
                addSkillBtn.style.background = '#3e2a57';
                addSkillBtn.style.transform = 'scale(1.1)';
                addSkillBtn.style.opacity = '1';
            });
            
            addSkillBtn.addEventListener('mouseleave', () => {
                addSkillBtn.style.background = '#5d3f7e';
                addSkillBtn.style.transform = 'scale(1)';
                addSkillBtn.style.opacity = '0.7';
            });
            
            addSkillBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                openAddSkillModal(category, categoryName, categoryId);
            });
            
            skillsList.appendChild(addSkillBtn);
            
            // Add edit and delete buttons to each skill
            skillsList.querySelectorAll('li:not(:last-child)').forEach((skill, skillIndex) => {
                // Skip if it's the add button
                if (skill.textContent === '+') return;
                
                const skillName = skill.textContent.trim();
                const skillId = skill.dataset.id;
                
                if (!skillId || skillId === 'undefined') {
                    console.warn('Skill has no ID:', skillName);
                    return;
                }
                
                console.log(`Adding delete to skill: ${skillName}, ID: ${skillId}`);
                
                // Create delete button
                const deleteBtn = document.createElement('span');
                deleteBtn.innerHTML = '🗑️';
                deleteBtn.style.cssText = `
                    margin-left: 0.5rem;
                    cursor: pointer;
                    font-size: 0.9rem;
                    color: #f44336;
                    opacity: 0.5;
                    transition: opacity 0.3s;
                `;
                
                skill.appendChild(deleteBtn);
                skill.style.position = 'relative';
                
                skill.addEventListener('mouseenter', () => {
                    deleteBtn.style.opacity = '1';
                });
                
                skill.addEventListener('mouseleave', () => {
                    deleteBtn.style.opacity = '0.5';
                });
                
                deleteBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    
                    if (confirm(`Delete skill "${skillName}" from database?`)) {
                        deleteSkill(skillId, skill);
                    }
                });
            });
        });
    }
    
    function deleteSkill(skillId, skillElement) {
        // Show loading state
        skillElement.style.opacity = '0.5';
        
        console.log('Deleting skill ID:', skillId);
        
        fetch(`/api/admin/skills/delete/${skillId}`, {
            method: 'DELETE'
        })
        .then(response => response.json())
        .then(data => {
            console.log('Delete response:', data);
            if (data.status === 'success') {
                skillElement.remove();
                showNotification('✅ Skill deleted!', 'success');
            } else {
                skillElement.style.opacity = '1';
                showNotification('❌ Error: ' + data.message, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            skillElement.style.opacity = '1';
            showNotification('❌ Connection error', 'error');
        });
    }
    
    function addEditButton(element, type, id) {
        const editBtn = document.createElement('button');
        editBtn.className = 'admin-edit-btn';
        editBtn.innerHTML = '✎ Edit';
        editBtn.setAttribute('data-type', type);
        editBtn.setAttribute('data-id', id);
        editBtn.style.cssText = `
            position: absolute;
            top: 10px;
            right: 50px;
            background: #5d3f7e;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            z-index: 100;
            opacity: 0;
            transition: opacity 0.3s;
            box-shadow: 0 2px 10px rgba(93,63,126,0.3);
        `;
        
        element.style.position = 'relative';
        element.appendChild(editBtn);
        
        element.addEventListener('mouseenter', () => {
            editBtn.style.opacity = '1';
        });
        
        element.addEventListener('mouseleave', () => {
            editBtn.style.opacity = '0';
        });
        
        editBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            openEditModal(type, id, element);
        });
    }
    
    function addDeleteButton(element, type, id) {
        const deleteBtn = document.createElement('button');
        deleteBtn.className = 'admin-delete-btn';
        deleteBtn.innerHTML = '🗑️ Delete';
        deleteBtn.setAttribute('data-type', type);
        deleteBtn.setAttribute('data-id', id);
        deleteBtn.style.cssText = `
            position: absolute;
            top: 10px;
            right: 10px;
            background: #f44336;
            color: white;
            border: none;
            border-radius: 20px;
            padding: 5px 10px;
            cursor: pointer;
            font-size: 12px;
            z-index: 100;
            opacity: 0;
            transition: opacity 0.3s;
            box-shadow: 0 2px 10px rgba(244,67,54,0.3);
        `;
        
        element.appendChild(deleteBtn);
        
        element.addEventListener('mouseenter', () => {
            deleteBtn.style.opacity = '1';
        });
        
        element.addEventListener('mouseleave', () => {
            deleteBtn.style.opacity = '0';
        });
        
        deleteBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            
            // Get the actual ID from the element's data attribute
            const elementId = element.dataset.id;
            console.log('Delete clicked for', type, 'with ID:', elementId);
            
            if (!elementId) {
                alert('Error: Could not find ID for this item');
                return;
            }
            
            confirmDelete(type, elementId, element);
        });
    }
    
    function confirmDelete(type, id, element) {
        if (!id || id === 'undefined') {
            alert('Error: Could not find ID for this item');
            return;
        }
        
        if (!confirm(`Delete this ${type}?`)) return;
        
        let endpoint;
        if (type === 'special') {
            endpoint = `/api/admin/special-skills/delete/${id}`;
        } else if (type === 'hobby') {
            endpoint = `/api/admin/hobbies/delete/${id}`;
        } else if (type === 'project') {
            endpoint = `/api/admin/projects/delete/${id}`;
        } else if (type === 'education') {
            endpoint = `/api/admin/education/delete/${id}`;
        } else if (type === 'work-experience') {
            endpoint = `/api/admin/work-experience/delete/${id}`;
        } else if (type === 'soft-skill') {
            endpoint = `/api/admin/soft-skills/delete/${id}`;
        } else {
            endpoint = `/api/admin/${type}s/delete/${id}`;
        }
        
        element.style.opacity = '0.5';
        
        fetch(endpoint, { method: 'DELETE' })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                element.remove();
                showNotification(`✅ ${type} deleted!`, 'success');
            } else {
                element.style.opacity = '1';
                showNotification(`❌ Error: ${data.message}`, 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            element.style.opacity = '1';
            showNotification('❌ Connection error', 'error');
        });
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#4CAF50' : '#f44336'};
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            z-index: 3000;
            animation: slideIn 0.3s ease;
            font-weight: 500;
        `;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    function openEditModal(type, id, element) {
        // Get data from the element
        let data = {};
        
        if (type === 'hobby') {
            data = {
                title: element.querySelector('h3')?.textContent || '',
                icon: element.querySelector('.hobby-icon')?.textContent || '🧶',
                description: element.querySelector('.hobby-details p')?.textContent || '',
                favorite: element.querySelector('.hobby-fav')?.textContent?.replace('favourites: ', '') || ''
            };
        } else if (type === 'project') {
            data = {
                title: element.querySelector('h3')?.textContent || '',
                tags: element.querySelector('.project-tags')?.textContent || '',
                description: element.querySelector('.project-description')?.textContent || '',
                challenge: element.querySelector('.project-challenge span:last-child')?.textContent || ''
            };
        } else if (type === 'special') {
            // Get the icon from the skill-emoji span
            const iconElement = element.querySelector('.skill-emoji');
            const detailsList = element.querySelector('.skill-detail ul');
            
            // Convert HTML list to plain text with line breaks
            let detailsText = '';
            if (detailsList) {
                const items = detailsList.querySelectorAll('li');
                detailsText = Array.from(items).map(item => item.textContent.trim()).join('\n');
            }
            
            data = {
                title: element.querySelector('h3')?.textContent || '',
                icon: iconElement?.textContent || '🧠',
                description: element.querySelector('p')?.textContent || '',
                details: detailsText
            };
        } else if (type === 'education') {
            // Extract education data
            const degree = element.querySelector('h3')?.textContent || '';
            const schoolText = element.querySelector('.edu-school')?.textContent || '';
            const schoolParts = schoolText.split('·');
            const school = schoolParts[0]?.trim() || '';
            const location = schoolParts[1]?.trim() || '';
            
            // Get date range
            const dateElement = element.querySelector('.education-date');
            let startDate = '';
            let endDate = '';
            
            if (dateElement) {
                const dateText = dateElement.textContent || '';
                const dateParts = dateText.split('-');
                if (dateParts.length > 0) {
                    startDate = dateParts[0]?.trim() || '';
                    endDate = dateParts[1]?.trim() || '';
                }
            }
            
            // Get GPA
            const gpaElement = element.querySelector('.edu-gpa');
            const gpa = gpaElement ? gpaElement.textContent?.replace('GPA: ', '').trim() : '';
            
            const description = element.querySelector('.edu-description')?.textContent || '';
            
            data = {
                degree: degree,
                school: school,
                location: location,
                start_date: startDate,
                end_date: endDate,
                gpa: gpa,
                description: description
            };
        } else if (type === 'work-experience') {
            // Extract work experience data
            const position = element.querySelector('h3')?.textContent || '';
            
            // Get company and location
            const companyElement = element.querySelector('h4');
            let company = '';
            let location = '';
            
            if (companyElement) {
                const companyText = companyElement.textContent || '';
                const companyParts = companyText.split('·');
                company = companyParts[0]?.trim() || '';
                location = companyParts[1]?.trim() || '';
            }
            
            // Get date range
            const dateElement = element.querySelector('.timeline-date');
            let startDate = '';
            let endDate = '';
            
            if (dateElement) {
                const dateText = dateElement.textContent || '';
                const dateParts = dateText.split('-');
                if (dateParts.length > 0) {
                    startDate = dateParts[0]?.trim() || '';
                    endDate = dateParts[1]?.trim() || '';
                }
            }
            
            const description = element.querySelector('.timeline-description')?.textContent || '';
            
            data = {
                position: position,
                company: company,
                location: location,
                start_date: startDate,
                end_date: endDate,
                description: description
            };
        } else if (type === 'soft-skill') {
            data = {
                title: element.querySelector('h3')?.textContent || '',
                icon: element.querySelector('.soft-skill-icon')?.textContent || '🤝',
                description: element.querySelector('p')?.textContent || ''
            };
        }
        
        // Create edit modal
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(46,26,71,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            backdrop-filter: blur(5px);
        `;
        
        const content = document.createElement('div');
        content.style.cssText = `
            background: white;
            padding: 2rem;
            border-radius: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
        `;
        
        // Build form fields based on type
        let formFields = '';
        
        if (type === 'hobby') {
            for (let key in data) {
                formFields += `
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e; font-weight: 500; text-transform: capitalize;">${key}</label>
                        <input type="text" name="${key}" value="${data[key].replace(/"/g, '&quot;')}" style="
                            width: 100%;
                            padding: 0.8rem 1.2rem;
                            border: 2px solid #e4d0ff;
                            border-radius: 30px;
                            font-size: 1rem;
                            box-sizing: border-box;
                        ">
                    </div>
                `;
            }
        } else if (type === 'project') {
            for (let key in data) {
                formFields += `
                    <div style="margin-bottom: 1rem;">
                        <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e; font-weight: 500; text-transform: capitalize;">${key}</label>
                        <input type="text" name="${key}" value="${data[key].replace(/"/g, '&quot;')}" style="
                            width: 100%;
                            padding: 0.8rem 1.2rem;
                            border: 2px solid #e4d0ff;
                            border-radius: 30px;
                            font-size: 1rem;
                            box-sizing: border-box;
                        ">
                    </div>
                `;
            }
        } else if (type === 'special') {
            // Special skills have title, icon, description, and details
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e; font-weight: 500;">Title</label>
                    <input type="text" name="title" value="${data.title.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e; font-weight: 500;">Icon (emoji)</label>
                    <input type="text" name="icon" value="${data.icon.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " placeholder="e.g., 🧠">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e; font-weight: 500;">Description</label>
                    <textarea name="description" rows="2" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>${data.description.replace(/"/g, '&quot;')}</textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e; font-weight: 500;">Details</label>
                    <textarea name="details" rows="3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                        resize: vertical;
                    " placeholder="One detail per line">${data.details.replace(/"/g, '&quot;')}</textarea>
                </div>
            `;
        } else if (type === 'education') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Degree</label>
                    <input type="text" name="degree" value="${data.degree.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">School</label>
                    <input type="text" name="school" value="${data.school.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Location</label>
                    <input type="text" name="location" value="${data.location.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Start Date</label>
                    <input type="text" name="start_date" value="${data.start_date}" placeholder="e.g., 2021 or June 2021" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">End Date</label>
                    <input type="text" name="end_date" value="${data.end_date}" placeholder="e.g., 2025, Present, or leave empty" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">GPA</label>
                    <input type="text" name="gpa" value="${data.gpa.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" rows="3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">${data.description.replace(/"/g, '&quot;')}</textarea>
                </div>
            `;
        } else if (type === 'work-experience') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Position</label>
                    <input type="text" name="position" value="${data.position.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Company</label>
                    <input type="text" name="company" value="${data.company.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Location</label>
                    <input type="text" name="location" value="${data.location.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Start Date</label>
                    <input type="text" name="start_date" value="${data.start_date}" placeholder="e.g., June 2021" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">End Date</label>
                    <input type="text" name="end_date" value="${data.end_date}" placeholder="e.g., December 2023, Present, or leave empty" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" rows="4" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>${data.description.replace(/"/g, '&quot;')}</textarea>
                </div>
            `;
        } else if (type === 'soft-skill') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Title</label>
                    <input type="text" name="title" value="${data.title.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Icon (emoji)</label>
                    <input type="text" name="icon" value="${data.icon.replace(/"/g, '&quot;')}" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" rows="3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>${data.description.replace(/"/g, '&quot;')}</textarea>
                </div>
            `;
        }
        
        content.innerHTML = `
            <span style="position: absolute; top: 1rem; right: 1.5rem; font-size: 2rem; cursor: pointer; color: #5d3f7e;" onclick="this.closest('.admin-modal').remove()">&times;</span>
            <h2 style="color: #2e1a47; margin-bottom: 1.5rem;">Edit ${type}</h2>
            <form id="editForm">
                ${formFields}
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" style="
                        flex: 1;
                        background: #5d3f7e;
                        color: white;
                        border: none;
                        padding: 0.8rem;
                        border-radius: 30px;
                        cursor: pointer;
                        font-size: 1rem;
                    ">Save Changes</button>
                    <button type="button" onclick="this.closest('.admin-modal').remove()" style="
                        flex: 1;
                        background: #e4d0ff;
                        color: #2e1a47;
                        border: none;
                        padding: 0.8rem;
                        border-radius: 30px;
                        cursor: pointer;
                        font-size: 1rem;
                    ">Cancel</button>
                </div>
            </form>
            <div id="editFeedback" style="margin-top: 1rem; text-align: center;"></div>
        `;
        
        modal.appendChild(content);
        modal.classList.add('admin-modal');
        document.body.appendChild(modal);
        
        // Handle form submission
        const form = modal.querySelector('#editForm');
        const feedback = modal.querySelector('#editFeedback');
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            // Disable submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';
            feedback.textContent = '⏳ Updating database...';
            feedback.style.color = '#5d3f7e';
            
            try {
                // Send update to database
                let endpoint;
                if (type === 'special') {
                    endpoint = `/api/admin/special-skills/update/${id}`;
                } else if (type === 'hobby') {
                    endpoint = `/api/admin/hobbies/update/${id}`;
                } else if (type === 'project') {
                    endpoint = `/api/admin/projects/update/${id}`;
                } else if (type === 'education') {
                    endpoint = `/api/admin/education/update/${id}`;
                } else if (type === 'work-experience') {
                    endpoint = `/api/admin/work-experience/update/${id}`;
                } else if (type === 'soft-skill') {
                    endpoint = `/api/admin/soft-skills/update/${id}`;
                } else {
                    endpoint = `/api/admin/${type}s/update/${id}`;
                }
                
                const response = await fetch(endpoint, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    feedback.textContent = '✅ Updated! Refreshing...';
                    feedback.style.color = '#4CAF50';
                    
                    // Refresh the page after 1 second
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    feedback.textContent = '❌ Error: ' + data.message;
                    feedback.style.color = '#f44336';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Save Changes';
                }
            } catch (error) {
                console.error('Error:', error);
                feedback.textContent = '❌ Connection error';
                feedback.style.color = '#f44336';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Save Changes';
            }
        });
    }
    
    function addAddNewButtons() {
        // Add "Add New Hobby" card
        const hobbiesGrid = document.querySelector('.hobbies-grid');
        if (hobbiesGrid) {
            const addCard = createAddCard('hobby', 'Add New Hobby');
            hobbiesGrid.appendChild(addCard);
        }
        
        // Add "Add New Project" card
        const projectsGrid = document.querySelector('.projects-grid');
        if (projectsGrid) {
            const addCard = createAddCard('project', 'Add New Project');
            projectsGrid.appendChild(addCard);
        }
        
        // Add "Add New Special Skill" card
        const specialGrid = document.querySelector('.special-grid');
        if (specialGrid) {
            const addCard = createAddCard('special', 'Add New Special Skill');
            specialGrid.appendChild(addCard);
        }
    }
    
    function createAddCard(type, label) {
        const card = document.createElement('div');
        card.className = type === 'project' ? 'project-card' : 
                        type === 'hobby' ? 'hobby-card' : 'special-skill-card';
        card.style.cssText = `
            background: rgba(93, 63, 126, 0.1);
            border: 3px dashed #5d3f7e;
            min-height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            padding: 2rem;
            border-radius: 28px;
        `;
        
        card.innerHTML = `
            <span style="font-size: 3rem; color: #5d3f7e;">+</span>
            <h3 style="color: #5d3f7e; margin-top: 1rem; text-align: center;">${label}</h3>
        `;
        
        card.addEventListener('mouseenter', () => {
            card.style.background = 'rgba(93, 63, 126, 0.2)';
            card.style.transform = 'scale(1.02)';
        });
        
        card.addEventListener('mouseleave', () => {
            card.style.background = 'rgba(93, 63, 126, 0.1)';
            card.style.transform = 'scale(1)';
        });
        
        card.addEventListener('click', () => {
            openAddModal(type);
        });
        
        return card;
    }
    
    function openAddSkillModal(category, categoryName, categoryId) {
        console.log('Opening add skill modal for category:', categoryName, 'with ID:', categoryId);
        
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(46,26,71,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            backdrop-filter: blur(5px);
        `;
        
        const content = document.createElement('div');
        content.style.cssText = `
            background: white;
            padding: 2rem;
            border-radius: 30px;
            max-width: 400px;
            width: 90%;
            position: relative;
            animation: modalSlideIn 0.3s ease;
        `;
        
        content.innerHTML = `
            <span style="position: absolute; top: 1rem; right: 1.5rem; font-size: 2rem; cursor: pointer; color: #5d3f7e;" onclick="this.closest('.admin-modal').remove()">&times;</span>
            <h2 style="color: #2e1a47; margin-bottom: 1.5rem;">Add Skill to ${categoryName}</h2>
            <form id="addSkillForm">
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Skill Name</label>
                    <input type="text" name="skill" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " placeholder="e.g., TypeScript" required>
                </div>
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" style="
                        flex: 1;
                        background: #5d3f7e;
                        color: white;
                        border: none;
                        padding: 0.8rem;
                        border-radius: 30px;
                        cursor: pointer;
                        font-size: 1rem;
                    ">Add Skill to Database</button>
                    <button type="button" onclick="this.closest('.admin-modal').remove()" style="
                        flex: 1;
                        background: #e4d0ff;
                        color: #2e1a47;
                        border: none;
                        padding: 0.8rem;
                        border-radius: 30px;
                        cursor: pointer;
                        font-size: 1rem;
                    ">Cancel</button>
                </div>
            </form>
            <div id="skillFeedback" style="margin-top: 1rem; text-align: center;"></div>
        `;
        
        modal.appendChild(content);
        document.body.appendChild(modal);
        
        const form = modal.querySelector('#addSkillForm');
        const feedback = modal.querySelector('#skillFeedback');
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const skillName = form.querySelector('input[name="skill"]').value.trim();
            
            if (!skillName) {
                feedback.textContent = '❌ Please enter a skill name';
                feedback.style.color = '#f44336';
                return;
            }
            
            // Disable submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';
            feedback.textContent = '⏳ Saving to database...';
            feedback.style.color = '#5d3f7e';
            
            try {
                // Save to database
                console.log('Sending to database - Category ID:', categoryId, 'Skill:', skillName);
                
                const response = await fetch('/api/admin/skills/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `category_id=${categoryId}&name=${encodeURIComponent(skillName)}&display_order=99`
                });
                
                const data = await response.json();
                console.log('Response:', data);
                
                if (data.status === 'success') {
                    feedback.textContent = '✅ Skill added to database! Refreshing...';
                    feedback.style.color = '#4CAF50';
                    
                    // Refresh to show new skill
                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                } else {
                    feedback.textContent = '❌ Error: ' + data.message;
                    feedback.style.color = '#f44336';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Add Skill to Database';
                }
            } catch (error) {
                console.error('Error:', error);
                feedback.textContent = '❌ Connection error';
                feedback.style.color = '#f44336';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Add Skill to Database';
            }
        });
    }
    
    function openAddModal(type) {
        console.log('Opening add modal for type:', type);
        
        const modal = document.createElement('div');
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(46,26,71,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            backdrop-filter: blur(5px);
        `;
        
        let formFields = '';
        if (type === 'hobby') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Title</label>
                    <input type="text" name="title" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Icon</label>
                    <input type="text" name="icon" class="form-input" value="🧶" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" class="form-input" rows="3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                        resize: vertical;
                    " required></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Favorite</label>
                    <input type="text" name="favorite" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
            `;
        } else if (type === 'project') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Title</label>
                    <input type="text" name="title" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Tags</label>
                    <input type="text" name="tags" class="form-input" value="New Project" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" class="form-input" rows="3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                        resize: vertical;
                    " required></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Challenge</label>
                    <textarea name="challenge" class="form-input" rows="2" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    "></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Color</label>
                    <input type="text" name="color" class="form-input" value="#cbc3e3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
            `;
        } else if (type === 'special') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Title</label>
                    <input type="text" name="title" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Icon (emoji)</label>
                    <input type="text" name="icon" class="form-input" value="🧠" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" class="form-input" rows="2" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                        resize: vertical;
                    " required></textarea>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Details</label>
                    <textarea name="details" class="form-input" rows="3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                        resize: vertical;
                    "></textarea>
                </div>
            `;
        } else if (type === 'education') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Degree</label>
                    <input type="text" name="degree" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">School</label>
                    <input type="text" name="school" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Location</label>
                    <input type="text" name="location" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Start Date</label>
                    <input type="text" name="start_date" class="form-input" placeholder="e.g., 2021" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">End Date</label>
                    <input type="text" name="end_date" class="form-input" placeholder="e.g., 2025 or Present" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">GPA</label>
                    <input type="text" name="gpa" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" class="form-input" rows="3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    "></textarea>
                </div>
            `;
        } else if (type === 'work-experience') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Position</label>
                    <input type="text" name="position" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Company</label>
                    <input type="text" name="company" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Location</label>
                    <input type="text" name="location" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Start Date</label>
                    <input type="text" name="start_date" class="form-input" placeholder="e.g., June 2021" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">End Date</label>
                    <input type="text" name="end_date" class="form-input" placeholder="e.g., December 2023 or Present" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" class="form-input" rows="4" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required></textarea>
                </div>
            `;
        } else if (type === 'soft-skill') {
            formFields = `
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Title</label>
                    <input type="text" name="title" class="form-input" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required>
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Icon (emoji)</label>
                    <input type="text" name="icon" class="form-input" value="🤝" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    ">
                </div>
                <div style="margin-bottom: 1rem;">
                    <label style="display: block; margin-bottom: 0.5rem; color: #5d3f7e;">Description</label>
                    <textarea name="description" class="form-input" rows="3" style="
                        width: 100%;
                        padding: 0.8rem 1.2rem;
                        border: 2px solid #e4d0ff;
                        border-radius: 30px;
                        font-size: 1rem;
                        box-sizing: border-box;
                    " required></textarea>
                </div>
            `;
        }
        
        const content = document.createElement('div');
        content.style.cssText = `
            background: white;
            padding: 2rem;
            border-radius: 30px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            position: relative;
            animation: modalSlideIn 0.3s ease;
        `;
        
        content.innerHTML = `
            <span style="position: absolute; top: 1rem; right: 1.5rem; font-size: 2rem; cursor: pointer; color: #5d3f7e;" onclick="this.closest('.admin-modal').remove()">&times;</span>
            <h2 style="color: #2e1a47; margin-bottom: 1.5rem;">Add New ${type}</h2>
            <form id="addForm">
                ${formFields}
                <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                    <button type="submit" style="
                        flex: 1;
                        background: #5d3f7e;
                        color: white;
                        border: none;
                        padding: 0.8rem;
                        border-radius: 30px;
                        cursor: pointer;
                        font-size: 1rem;
                    ">Save to Database</button>
                    <button type="button" onclick="this.closest('.admin-modal').remove()" style="
                        flex: 1;
                        background: #e4d0ff;
                        color: #2e1a47;
                        border: none;
                        padding: 0.8rem;
                        border-radius: 30px;
                        cursor: pointer;
                        font-size: 1rem;
                    ">Cancel</button>
                </div>
            </form>
            <div id="formFeedback" style="margin-top: 1rem; text-align: center;"></div>
        `;
        
        modal.appendChild(content);
        document.body.appendChild(modal);
        
        // Handle form submission
        const form = modal.querySelector('#addForm');
        const feedback = modal.querySelector('#formFeedback');
        
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            
            // Disable submit button
            const submitBtn = form.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'Saving...';
            feedback.textContent = '⏳ Saving to database...';
            feedback.style.color = '#5d3f7e';
            
            try {
                // Send to database
                let endpoint;
                if (type === 'special') {
                    endpoint = '/api/admin/special-skills/add';
                } else if (type === 'hobby') {
                    endpoint = '/api/admin/hobbies/add';
                } else if (type === 'project') {
                    endpoint = '/api/admin/projects/add';
                } else if (type === 'education') {
                    endpoint = '/api/admin/education/add';
                } else if (type === 'work-experience') {
                    endpoint = '/api/admin/work-experience/add';
                } else if (type === 'soft-skill') {
                    endpoint = '/api/admin/soft-skills/add';
                } else {
                    endpoint = `/api/admin/${type}s/add`;
                }
                
                const response = await fetch(endpoint, {
                    method: 'POST',
                    body: formData
                });
                
                const data = await response.json();
                
                if (data.status === 'success') {
                    feedback.textContent = '✅ Saved successfully! Refreshing...';
                    feedback.style.color = '#4CAF50';
                    
                    // Refresh the page after 1 second to show new data
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                } else {
                    feedback.textContent = '❌ Error: ' + data.message;
                    feedback.style.color = '#f44336';
                    submitBtn.disabled = false;
                    submitBtn.textContent = 'Save to Database';
                }
            } catch (error) {
                console.error('Error:', error);
                feedback.textContent = '❌ Connection error';
                feedback.style.color = '#f44336';
                submitBtn.disabled = false;
                submitBtn.textContent = 'Save to Database';
            }
        });
    }

    // ===== FUNCTIONS FOR EDUCATION, WORK EXPERIENCE, AND SOFT SKILLS =====
    function addControlsToEducation() {
        document.querySelectorAll('.education-card').forEach((card, index) => {
            // Skip the "Add New" cards
            if (card.classList.contains('add-new-card')) return;
            
            const cardId = card.dataset.id;
            if (cardId) {
                addEditButton(card, 'education', cardId);
                addDeleteButton(card, 'education', cardId);
            }
        });
    }
    
    function addControlsToWorkExperience() {
        document.querySelectorAll('.experience-card').forEach((card, index) => {
            // Skip the "Add New" cards
            if (card.classList.contains('add-new-card')) return;
            
            const cardId = card.dataset.id;
            if (cardId) {
                addEditButton(card, 'work-experience', cardId);
                addDeleteButton(card, 'work-experience', cardId);
            }
        });
    }
    
    function addControlsToSoftSkills() {
        document.querySelectorAll('.soft-skill-card').forEach((card, index) => {
            // Skip the "Add New" cards
            if (card.classList.contains('add-new-card')) return;
            
            const cardId = card.dataset.id;
            if (cardId) {
                addEditButton(card, 'soft-skill', cardId);
                addDeleteButton(card, 'soft-skill', cardId);
            }
        });
    }
    
    function addNewSectionButtons() {
        // Add Education "Add New" card
        const educationGrid = document.querySelector('.education-grid');
        if (educationGrid && !document.querySelector('.add-education-card')) {
            const addCard = document.createElement('div');
            addCard.className = 'education-card add-new-card add-education-card';
            addCard.style.cssText = `
                background: rgba(93, 63, 126, 0.1);
                border: 3px dashed #5d3f7e;
                min-height: 200px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s;
                padding: 2rem;
                border-radius: 28px;
            `;
            
            addCard.innerHTML = `
                <span style="font-size: 3rem; color: #5d3f7e;">+</span>
                <h3 style="color: #5d3f7e; margin-top: 1rem; text-align: center;">Add New Education</h3>
            `;
            
            addCard.addEventListener('mouseenter', () => {
                addCard.style.background = 'rgba(93, 63, 126, 0.2)';
                addCard.style.transform = 'scale(1.02)';
            });
            
            addCard.addEventListener('mouseleave', () => {
                addCard.style.background = 'rgba(93, 63, 126, 0.1)';
                addCard.style.transform = 'scale(1)';
            });
            
            addCard.addEventListener('click', () => {
                openAddModal('education');
            });
            
            educationGrid.appendChild(addCard);
        }
        
        // Add Work Experience "Add New" card
        const experienceGrid = document.querySelector('.experience-grid');
        if (experienceGrid && !document.querySelector('.add-experience-card')) {
            const addCard = document.createElement('div');
            addCard.className = 'experience-card add-new-card add-experience-card';
            addCard.style.cssText = `
                background: rgba(93, 63, 126, 0.1);
                border: 3px dashed #5d3f7e;
                min-height: 200px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s;
                padding: 2rem;
                border-radius: 28px;
            `;
            
            addCard.innerHTML = `
                <span style="font-size: 3rem; color: #5d3f7e;">+</span>
                <h3 style="color: #5d3f7e; margin-top: 1rem; text-align: center;">Add New Experience</h3>
            `;
            
            addCard.addEventListener('mouseenter', () => {
                addCard.style.background = 'rgba(93, 63, 126, 0.2)';
                addCard.style.transform = 'scale(1.02)';
            });
            
            addCard.addEventListener('mouseleave', () => {
                addCard.style.background = 'rgba(93, 63, 126, 0.1)';
                addCard.style.transform = 'scale(1)';
            });
            
            addCard.addEventListener('click', () => {
                openAddModal('work-experience');
            });
            
            experienceGrid.appendChild(addCard);
        }
        
        // Add Soft Skills "Add New" card
        const softSkillsGrid = document.querySelector('.soft-skills-grid');
        if (softSkillsGrid && !document.querySelector('.add-softskill-card')) {
            const addCard = document.createElement('div');
            addCard.className = 'soft-skill-card add-new-card add-softskill-card';
            addCard.style.cssText = `
                background: rgba(93, 63, 126, 0.1);
                border: 3px dashed #5d3f7e;
                min-height: 200px;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s;
                padding: 2rem;
                border-radius: 28px;
            `;
            
            addCard.innerHTML = `
                <span style="font-size: 3rem; color: #5d3f7e;">+</span>
                <h3 style="color: #5d3f7e; margin-top: 1rem; text-align: center;">Add New Soft Skill</h3>
            `;
            
            addCard.addEventListener('mouseenter', () => {
                addCard.style.background = 'rgba(93, 63, 126, 0.2)';
                addCard.style.transform = 'scale(1.02)';
            });
            
            addCard.addEventListener('mouseleave', () => {
                addCard.style.background = 'rgba(93, 63, 126, 0.1)';
                addCard.style.transform = 'scale(1)';
            });
            
            addCard.addEventListener('click', () => {
                openAddModal('soft-skill');
            });
            
            softSkillsGrid.appendChild(addCard);
        }
    }

    // ========== CERTIFICATION FUNCTIONS ==========
    
    // Store scroll position
    let lastScrollPosition = 0;

    // Save scroll position before any action
    function saveScrollPosition() {
        lastScrollPosition = window.pageYOffset || document.documentElement.scrollTop;
        sessionStorage.setItem('lastScrollPosition', lastScrollPosition.toString());
    }

    // Restore scroll position after action
    function restoreScrollPosition() {
        window.scrollTo({
            top: lastScrollPosition,
            behavior: 'instant'
        });
    }

    // PDF Viewer Function
    window.viewPDF = function(pdfPath, title) {
        const modal = document.getElementById('certModal');
        const modalTitle = document.getElementById('modalCertTitle');
        const pdfViewer = document.getElementById('pdfViewer');
        
        modalTitle.textContent = title || 'Certificate';
        
        if (pdfPath && pdfPath.match(/\.pdf$/i)) {
            pdfViewer.innerHTML = `<embed src="${pdfPath}?t=${new Date().getTime()}#toolbar=0&navpanes=0&scrollbar=0" 
                                          type="application/pdf" 
                                          width="100%" 
                                          height="100%" 
                                          style="border: none; display: block;" />`;
        } else {
            pdfViewer.innerHTML = '<p style="text-align: center; color: #999; margin-top: 100px;">PDF not available</p>';
        }
        
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    // Close PDF Modal Function
    window.closePDFModal = function() {
        const modal = document.getElementById('certModal');
        const pdfViewer = document.getElementById('pdfViewer');
        
        if (modal) {
            modal.style.display = 'none';
            pdfViewer.innerHTML = '';
            document.body.style.overflow = 'auto';
        }
    }
    
    // Add Certification Modal Function
    window.openAddCertificationModal = function() {
        // Save current scroll position
        saveScrollPosition();
        
        // Create modal if it doesn't exist
        let modal = document.getElementById('addCertModal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'addCertModal';
            modal.className = 'modal';
            modal.style.cssText = `
                display: none;
                position: fixed;
                z-index: 10000;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(46,26,71,0.95);
                backdrop-filter: blur(5px);
                overflow-y: auto;
                padding: 20px 0;
            `;
            
            modal.innerHTML = `
                <div class="modal-content">
                    <span class="close-btn" onclick="window.closeAddModal()">&times;</span>
                    
                    <h2>Add New Certificate</h2>
                    
                    <form method="POST" action="/admin/save-certification" enctype="multipart/form-data" id="addCertForm" onsubmit="saveScrollPosition()">
                        <input type="hidden" name="save_cert" value="1">
                        
                        <div class="form-group">
                            <label>Certificate Title *</label>
                            <input type="text" name="title" class="form-control" required placeholder="e.g., CSC Certificate">
                        </div>
                        
                        <div class="form-group">
                            <label>Issuer/Organization *</label>
                            <input type="text" name="issuer" class="form-control" required placeholder="e.g., Career Service Professional Examination">
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label>Rating</label>
                                <input type="text" name="rating" class="form-control" placeholder="e.g., 90.06%">
                            </div>
                            
                            <div class="form-group">
                                <label>Details</label>
                                <input type="text" name="examinee_no" class="form-control" placeholder="e.g., 311964">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Date Released</label>
                            <input type="text" name="date_released" class="form-control" placeholder="e.g., May 02, 2025">
                        </div>
                        
                        <div class="form-group">
                            <label>Certificate PDF</label>
                            <input type="file" name="pdf_file" class="form-control" accept=".pdf" style="padding-top: 0.6rem;">
                            <small style="color: #666; display: block; margin-top: 0.3rem; font-size: 0.8rem;">Only PDF files are allowed</small>
                        </div>
                        
                        <div class="button-group">
                            <button type="submit" class="btn-save">+ Add Certificate</button>
                            <button type="button" class="btn-cancel" onclick="window.closeAddModal()">Cancel</button>
                        </div>
                    </form>
                </div>
            `;
            
            document.body.appendChild(modal);
        } else {
            // Reset form for new entry
            const form = document.getElementById('addCertForm');
            if (form) {
                form.reset();
                
                // Remove any hidden fields from previous edit
                const hiddenFields = form.querySelectorAll('input[type="hidden"][name="cert_id"], input[type="hidden"][name="existing_pdf"]');
                hiddenFields.forEach(field => field.remove());
                
                // Remove any current PDF display
                const pdfDisplay = form.querySelector('.current-pdf');
                if (pdfDisplay) {
                    pdfDisplay.remove();
                }
            }
            
            // Reset title
            const modalTitle = modal.querySelector('h2');
            if (modalTitle) {
                modalTitle.textContent = 'Add New Certificate';
            }
            
            // Reset button text
            const submitBtn = modal.querySelector('.btn-save');
            if (submitBtn) {
                submitBtn.innerHTML = 'Add Certificate';
            }
        }
        
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    
    // Close Add Modal
    window.closeAddModal = function() {
        const modal = document.getElementById('addCertModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = 'auto';
            restoreScrollPosition();
        }
    }
    
    // Edit Certification Function
    window.editCertification = function(id) {
        fetch(`/admin/get-certification/${id}`)
            .then(response => response.json())
            .then(data => {
                // First, open the add modal
                window.openAddCertificationModal();
                
                // Change the title
                const modal = document.getElementById('addCertModal');
                const modalTitle = modal.querySelector('h2');
                if (modalTitle) {
                    modalTitle.textContent = 'Edit Certificate';
                }
                
                // Get the form
                const form = document.getElementById('addCertForm');
                
                // IMPORTANT: Remove existing hidden fields to avoid duplicates
                const existingCertId = form.querySelector('input[name="cert_id"]');
                if (existingCertId) existingCertId.remove();
                
                const existingPdf = form.querySelector('input[name="existing_pdf"]');
                if (existingPdf) existingPdf.remove();
                
                // Add hidden cert_id field
                const certIdField = document.createElement('input');
                certIdField.type = 'hidden';
                certIdField.name = 'cert_id';
                certIdField.value = id;
                form.appendChild(certIdField);
                
                // Add existing_pdf field
                const existingPdfField = document.createElement('input');
                existingPdfField.type = 'hidden';
                existingPdfField.name = 'existing_pdf';
                existingPdfField.value = data.pdf_path || '';
                form.appendChild(existingPdfField);
                
                // Populate form fields
                const titleField = form.querySelector('input[name="title"]');
                const issuerField = form.querySelector('input[name="issuer"]');
                const ratingField = form.querySelector('input[name="rating"]');
                const examineeField = form.querySelector('input[name="examinee_no"]');
                const dateField = form.querySelector('input[name="date_released"]');
                
                if (titleField) titleField.value = data.title || '';
                if (issuerField) issuerField.value = data.issuer || '';
                if (ratingField) ratingField.value = data.rating || '';
                if (examineeField) examineeField.value = data.examinee_no || '';
                if (dateField) dateField.value = data.date_released || '';
                
                // Add current PDF display
                const pdfContainer = form.querySelector('.form-group:has(input[type="file"])');
                if (pdfContainer && data.pdf_path) {
                    // Remove any existing current pdf display
                    const existingDisplay = pdfContainer.querySelector('.current-pdf');
                    if (existingDisplay) existingDisplay.remove();
                    
                    // Add new display
                    const pdfDisplay = document.createElement('div');
                    pdfDisplay.className = 'current-pdf';
                    pdfDisplay.innerHTML = `Current PDF: <a href="${data.pdf_path}" target="_blank">View PDF</a>`;
                    pdfContainer.appendChild(pdfDisplay);
                }
                
                // Change button text
                const submitBtn = form.querySelector('.btn-save');
                if (submitBtn) {
                    submitBtn.innerHTML = '💾 Update Certificate';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to load certification data.');
            });
    }
    
    // Delete Certification Function
    window.deleteCertification = function(id, title) {
        if (confirm(`Are you sure you want to delete "${title}"? This action cannot be undone.`)) {
            // Save scroll position before delete
            saveScrollPosition();
            // Create a form to submit the delete
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/admin/delete-certification';
            form.style.display = 'none';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'cert_id';
            input.value = id;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
    
    // Restore scroll position after page reload
    window.addEventListener('load', function() {
        const savedPosition = sessionStorage.getItem('lastScrollPosition');
        if (savedPosition) {
            window.scrollTo({
                top: parseInt(savedPosition),
                behavior: 'instant'
            });
            sessionStorage.removeItem('lastScrollPosition');
        }
    });
});